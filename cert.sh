#!/bin/bash

# Validación de instalación de docker-compose
docker_compose_cmd=$(command -v docker-compose)
if [ -z "$docker_compose_cmd" ]; then
  echo "Error: docker-compose no está instalado." >&2
  exit 1
fi

# Variables de configuración
domains=(edu.tecsify.com prodigy.tecsify.com certificados.tecsify.com)
rsa_key_size=4096
data_path="./data/certbot"
email="oscar@tecsify.com"
staging=0 # 1 para pruebas

# Unir dominios en una cadena
domain_list="${domains[*]}"

# Función para descargar parámetros TLS recomendados
download_tls_params() {
  echo "### Descargando parámetros TLS recomendados ..."
  mkdir -p "$data_path/conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot-nginx/certbot_nginx/_internal/tls_configs/options-ssl-nginx.conf > "$data_path/conf/options-ssl-nginx.conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot/certbot/ssl-dhparams.pem > "$data_path/conf/ssl-dhparams.pem"
  echo "Parámetros TLS descargados."
}

# Crear certificados temporales para todos los dominios
create_dummy_certificates() {
  echo "### Creando certificados temporales para $domain_list ..."
  for domain in "${domains[@]}"; do
    local path="/etc/letsencrypt/live/$domain"
    mkdir -p "$data_path/conf/live/$domain"
    docker-compose run --rm --entrypoint "\
      openssl req -x509 -nodes -newkey rsa:$rsa_key_size -days 1 \
      -keyout '$path/privkey.pem' -out '$path/fullchain.pem' \
      -subj '/CN=localhost'" certbot
  done
  echo "Certificados temporales creados para todos los dominios."
}

# Borrar certificados temporales de todos los dominios
delete_dummy_certificates() {
  echo "### Eliminando certificados temporales ..."
  for domain in "${domains[@]}"; do
    docker-compose run --rm --entrypoint "\
      rm -Rf /etc/letsencrypt/live/$domain /etc/letsencrypt/archive/$domain /etc/letsencrypt/renewal/$domain.conf" certbot
  done
  echo "Certificados temporales eliminados para todos los dominios."
}

# Solicitar certificados reales de Let's Encrypt para todos los dominios
request_letsencrypt_certificate() {
  local domain_args email_arg staging_arg=""
  
  # Configurar argumentos para dominios
  for domain in "${domains[@]}"; do
    domain_args="$domain_args -d $domain"
  done
  
  # Configurar email
  [ -z "$email" ] && email_arg="--register-unsafely-without-email" || email_arg="--email $email"
  
  # Modo de prueba
  [ $staging -ne 0 ] && staging_arg="--staging"
  
  echo "### Solicitando certificados Let's Encrypt para $domain_list ..."
  docker-compose run --rm --entrypoint "\
    certbot certonly --webroot -w /var/www/certbot \
    $staging_arg $email_arg $domain_args \
    --rsa-key-size $rsa_key_size \
    --agree-tos --force-renewal" certbot
}

# Comprobar TLS existente
if [ ! -e "$data_path/conf/options-ssl-nginx.conf" ] || [ ! -e "$data_path/conf/ssl-dhparams.pem" ]; then
  download_tls_params
fi

# Verificar si existen datos previos
if [ -d "$data_path" ]; then
  read -p "Datos existentes para $domain_list. ¿Deseas reemplazar los certificados? (y/N) " decision
  [[ "$decision" != "Y" && "$decision" != "y" ]] && exit
fi

create_dummy_certificates

echo "### Iniciando nginx ..."
docker-compose up -d nginx

delete_dummy_certificates

request_letsencrypt_certificate

echo "### Recargando nginx ..."
docker-compose exec nginx nginx -s reload && echo "nginx recargado exitosamente."
