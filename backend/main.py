from flask import Flask, request, send_file, jsonify
from flask_sqlalchemy import SQLAlchemy
from PIL import Image, ImageFont, ImageDraw
import os
from flask_cors import CORS
import textwrap
import uuid
import qrcode
import re

app = Flask(__name__)
app.app_context().push()
CORS(app)
host = "/backend"

app.config[
    "SQLALCHEMY_DATABASE_URI"
] = "mysql+pymysql://sql9653294:1zK2mUrWff@sql9.freemysqlhosting.net:3306/sql9653294"
db = SQLAlchemy(app)


class Usuarios(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nombre = db.Column(db.String(100), nullable=False)
    correo = db.Column(db.String(100), unique=True, nullable=False)
    identificacion = db.Column(db.String(20), unique=True, nullable=False)
    telefono = db.Column(db.String(15), nullable=False)
    estado = db.Column(db.Integer)

    def __init__(
        self,
        nombre,
        correo,
        identificacion,
        telefono,
        estado,
    ):
        self.nombre = nombre
        self.correo = correo
        self.identificacion = identificacion
        self.telefono = telefono
        self.estado = estado


class Certificados(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    nombre_certificado = db.Column(db.String(100), nullable=False)
    fecha = db.Column(db.Date, nullable=False)
    impartido_por = db.Column(db.String(100))
    evento_perteneciente = db.Column(db.String(100))
    estado = db.Column(db.Integer)


class CertificadosPorUsuario(db.Model):
    id = db.Column(db.String(100), primary_key=True, default=str(uuid.uuid4()))
    usuario_id = db.Column(db.Integer, db.ForeignKey("usuarios.id"))
    certificado_id = db.Column(db.Integer, db.ForeignKey("certificados.id"))
    usuario = db.relationship("Usuarios", backref="certificados_asociados")
    certificado = db.relationship("Certificados", backref="usuarios_asociados")


with app.app_context():
    db.create_all()


def generar_diploma(nombre, charla, id_cert):
    texto_cert_1 = f"https://certificados.tecsify.com/certificado/{id_cert}"
    texto_cert_2 = f"Código único de certificación: {id_cert}"

    # Obtén la ruta del directorio actual
    toFilePath = os.path.dirname(os.path.abspath(__file__))
    arial_font = os.path.join(toFilePath, 'arial.ttf')

    # Carga la imagen base del diploma
    empty_img = Image.open(os.path.join(toFilePath, "diploma.jpg"))

    # Configuración de fuentes y tamaño de texto
    max_font_size = 50
    font = ImageFont.truetype(arial_font, max_font_size)
    font_2 = ImageFont.truetype(arial_font, 40)
    font_3 = ImageFont.truetype(arial_font, 12)

    # Obtiene las dimensiones de la imagen base
    W, H = empty_img.size

    # Calcula las coordenadas para centrar el texto del nombre
    text = str(nombre)
    nombres = nombre.split(" ")
    if len(nombres) > 5:
        nombres = nombres[:2] + nombres[-2:]

    text = " ".join([n.capitalize() for n in nombres])

    # Ajusta el tamaño de la fuente del nombre si es demasiado ancho
    while font.getbbox(text)[2] > W:
        max_font_size -= 5
        font = ImageFont.truetype(arial_font, max_font_size)

    x0, x1, text_width, text_height = font.getbbox(text)
    text_x = (W - text_width) / 2
    text_y = H / 2.95

    # Crea un objeto ImageDraw para dibujar en la imagen
    image_editable = ImageDraw.Draw(empty_img)

    # Dibuja el nombre en el diploma
    image_editable.text((text_x, text_y), text, (3, 3, 153), font=font)

    # Configuración de fuentes y tamaño de texto para la charla

    # Calcula las coordenadas para centrar el texto de la charla
    text_charla = charla

    # Divide el texto de la charla en líneas según un ancho máximo
    charla_lines = textwrap.wrap(
        text_charla, width=47
    )  # Puedes ajustar el ancho máximo según tus necesidades
    text_y_charla = H / 1.9  # Inicializa la posición vertical
    font_size_charla = 35

    if len(charla_lines) == 1:
        text_y_charla = H / 1.9  # Inicializa la posición vertical
        font_size_charla = 40

    # Dibuja cada línea de la charla en el diploma
    for line in charla_lines:
        font_2 = ImageFont.truetype(arial_font, font_size_charla)
        x0, x1, text_width_charla, text_height_charla = font_2.getbbox(line)
        text_x_charla = (W - text_width_charla) / 2
        image_editable.text(
            (text_x_charla, text_y_charla), line, (3, 3, 3), font=font_2
        )
        text_y_charla += (
            text_height_charla  # Ajusta la posición vertical para la siguiente línea
        )

    # Calcula las coordenadas para los textos adicionales en la parte inferior
    x0, x1, text_width_cert_1, text_height_cert_1 = font_3.getbbox(texto_cert_1)
    text_x_cert_1 = (W - text_width_cert_1) / 2
    text_y_cert_1 = H - text_height_cert_1 - 57  # Ajusta la posición vertical

    x0, x1, text_width_cert_2, text_height_cert_2 = font_3.getbbox(texto_cert_2)
    text_x_cert_2 = (W - text_width_cert_2) / 2
    text_y_cert_2 = text_y_cert_1 + text_height_cert_1

    # Dibuja los textos adicionales en la parte inferior del diploma
    image_editable.text(
        (text_x_cert_1, text_y_cert_1), texto_cert_1, (3, 3, 3), font=font_3
    )
    image_editable.text(
        (text_x_cert_2, text_y_cert_2), texto_cert_2, (3, 3, 3), font=font_3
    )

    # Genera el código QR
    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_L,
        box_size=10,
        border=4,
    )
    qr.add_data(texto_cert_1)
    qr.make(fit=True)
    qr_img = qr.make_image(fill_color="#030399", back_color="#f4f4f4")
    qr_img = qr_img.resize((75, 75))

    # Pega el código QR en la imagen
    empty_img.paste(qr_img, (W - 115, H - 115))

    result_file = "result.pdf"
    empty_img.save(result_file)

    ruta_guardado = os.path.join(
        os.path.dirname(os.path.abspath(__file__)), "certificados"
    )  # Calcula la ruta completa para guardar el archivo en la carpeta "certificados"
    ruta_completa = os.path.join(ruta_guardado, f"{id_cert}.jpg")

    # Guarda el diploma como imagen JPG en la carpeta "certificados"
    empty_img.save(ruta_completa)

    return ruta_completa  # Devuelve la ruta donde se guardó el diploma


@app.route(host + "/usuarios", methods=["GET"])
def obtener_usuarios():
    usuarios = Usuarios.query.all()
    resultados = []
    for usuario in usuarios:
        resultados.append(
            {
                "id": usuario.id,
                "nombre": usuario.nombre,
                "correo": usuario.correo,
                "identificacion": usuario.identificacion,
                "telefono": usuario.telefono,
            }
        )
    return jsonify(resultados)


def validar_creacion_usuario(
    identificacion,
    correo,
):
    # Verificar si la identificación ya está en uso
    if Usuarios.query.filter_by(identificacion=identificacion).first():
        return (
            jsonify(
                {
                    "error": "El registro no pudo ser completado, esta identificación ya está en uso."
                }
            ),
            409,
        )

    # Verificar si el correo electrónico ya está en uso
    if Usuarios.query.filter_by(correo=correo).first():
        return (
            jsonify(
                {
                    "error": "El registro no pudo ser completado, este correo ya está en uso."
                }
            ),
            409,
        )

    return False  # El usuario no existe, pasa la validación


def validar_dato(dato, tipo):
    if tipo == "nombre":
        newdato = re.sub(r"[^A-Za-z-ÁáÉéÍíÓóÚú ]+", "", dato).upper()
    if tipo == "identificacion":
        newdato = re.sub(r"[^A-Za-z-0-9]+", "", dato).upper()
    if tipo == "numerico":
        newdato = re.sub(r"     ", "", str(dato))
    return newdato


@app.route(host + "/nuevo_usuario", methods=["POST"])
def nuevo_usuario():
    try:
        nombre = str(validar_dato(request.json["nombre"], "nombre")).upper()
        identificacion = validar_dato(request.json["identificacion"], "identificacion")
        correo = str(request.json["correo"]).lower()
        telefono = int(validar_dato(request.json["telefono"], "numerico"))
        estado = 1

        if not all([nombre, identificacion, correo, telefono]):
            return (
                jsonify(
                    {"error": "El registro no pudo ser completado campos incompletos "}
                ),
                400,
            )

        validacion = validar_creacion_usuario(identificacion, correo)
        if not validacion:
            nuevo_usurio = Usuarios(nombre, correo, identificacion, telefono, estado)
            db.session.add(nuevo_usurio)
            db.session.commit()
            return (
                jsonify(
                    {
                        "message": "Datos de usuario ingresados exitosamente",
                        "id": nuevo_usurio.id,
                        "nombre": nuevo_usurio.nombre,
                        "identificacion": nuevo_usurio.identificacion,
                    }
                ),
                201,
            )
        else:
            return validacion
    except KeyError as e:
        response = jsonify(
            {
                "error": "El registro no pudo ser completado, hace falta el campo "
                + str(e)
            }
        )
        response.status_code = 400
        return response
    except Exception as ex:
        response = jsonify(
            {
                "error": "El registro no pudo ser completado, intenta nuevamente. Error: "
                + str(ex)
            }
        )
        response.status_code = 500
        return response


# Ruta para obtener la lista de certificados
@app.route(host + "/certificados", methods=["GET"])
def obtener_certificados():
    certificados = Certificados.query.all()
    resultados = []
    for certificado in certificados:
        resultados.append(
            {
                "id": certificado.id,
                "nombre_certificado": certificado.nombre_certificado,
                "fecha": certificado.fecha.strftime("%Y-%m-%d"),
                "impartido_por": certificado.impartido_por,
                "evento_perteneciente": certificado.evento_perteneciente,
            }
        )
    return jsonify(resultados)


# Ruta para obtener la lista de certificados
@app.route(host + "/cfs", methods=["GET"])
def obtener_certificados_tots():
    certificados = CertificadosPorUsuario.query.all()
    resultados = []
    for certificado in certificados:
        resultados.append(
            {
                "id": certificado.id,
                "certificado_id": certificado.certificado_id,
                "usuario_id": certificado.usuario_id,
                
            }
        )
    return jsonify(resultados)


# Ruta para obtener información de un CertificadoPorUsuario por su UUID
@app.route(host + "/certificados_por_usuario/<uuid:certificado_id>", methods=["GET"])
def obtener_certificado_por_usuario(certificado_id):
    certificado_por_usuario = CertificadosPorUsuario.query.filter_by(
        id=str(certificado_id)
    ).first()
    if certificado_por_usuario is None:
        return jsonify({"message": "Certificado no encontrado"}), 404

    usuario = certificado_por_usuario.usuario
    certificado = certificado_por_usuario.certificado

    diploma = generar_diploma(
        usuario.nombre, certificado.nombre_certificado, certificado_por_usuario.id
    )

    return diploma


# Ruta para obtener información de un CertificadoPorUsuario por su UUID
@app.route(host + "/certificados_por_correo", methods=["POST"])
def obtener_certificado_por_correo():
    correo = str(request.json["correo"]).lower()
    
    usuario = Usuarios.query.filter_by(correo=correo).first()
    if not usuario:
        return jsonify({"message": "Usuario no encontrado"}), 404

    
    certificado_por_usuario = CertificadosPorUsuario.query.filter_by(usuario_id = usuario.id).all()
    if not certificado_por_usuario:
        return jsonify({"message": "Este usuario no tiene certificados"}), 404

    resultados = []
    datos_usuario = {
        "nombre": usuario.nombre,
        "correo": usuario.correo,
        "id": usuario.id,
    }
    for certificado in certificado_por_usuario:
        data_cert = Certificados.query.filter_by(id=certificado.certificado_id).first()
        if data_cert:
            resultados.append(
                {
                    "id": certificado.id,
                    "certificado_id": certificado.certificado_id,
                    "nombre_certificado": data_cert.nombre_certificado,
                    "certificado_impartido": data_cert.impartido_por,
                    "evento": data_cert.evento_perteneciente,
                    "fecha_certificado": data_cert.fecha,
                    
                }
            )
            
    return jsonify({"datos_usuario": datos_usuario, "certificados": resultados})



# Ruta para crear un CertificadoPorUsuario
@app.route(host + "/crear_certificado_por_usuario", methods=["POST"])
def crear_certificado_por_usuario():
    # Obtén los datos del formulario enviado
    usuario_id = int(request.form["usuario_id"])
    certificado_id = int(request.form["certificado_id"])

    # Verifica si el usuario y el certificado existen
    usuario = Usuarios.query.filter_by(id=usuario_id).first()
    certificado = Certificados.query.filter_by(id=certificado_id).first()

    if usuario is None or certificado is None:
        return "Usuario o certificado no encontrado", 404

    # Verifica si el usuario ya tiene este certificado
    certificado_por_usuario_existente = CertificadosPorUsuario.query.filter_by(
        usuario_id=usuario_id, certificado_id=certificado_id
    ).first()

    if certificado_por_usuario_existente:
        return "El usuario ya tiene este certificado", 409

    while True:
        # Generar un nuevo UUID
        nuevo_uuid = str(uuid.uuid4())

        # Comprobar si el UUID ya existe en la base de datos
        diploma_existente = CertificadosPorUsuario.query.filter_by(
            id=nuevo_uuid
        ).first()

        if not diploma_existente:
            break  # El UUID es único, sal del bucle

    # Crea un nuevo CertificadoPorUsuario
    nuevo_certificado_por_usuario = CertificadosPorUsuario(
        id=nuevo_uuid, usuario=usuario, certificado=certificado
    )

    db.session.add(nuevo_certificado_por_usuario)
    db.session.commit()

    # Genera el diploma y lo guarda con el mismo ID del CertificadoPorUsuario
    diploma_id = (
        nuevo_certificado_por_usuario.id
    )  # Utiliza el ID del CertificadoPorUsuario como ID del diploma
    rutadiploma = generar_diploma(
        usuario.nombre, certificado.nombre_certificado, diploma_id
    )

    return jsonify({"message": "Certificado creado: " + rutadiploma}), 201


@app.route(host + "/diploma/<uuid>")
def servir_diploma(uuid):
    ruta_diploma = os.path.join("certificados", f"{uuid}.jpg")
    if os.path.exists(ruta_diploma):
        return send_file(ruta_diploma)
    else:
        return jsonify({"message": "Diploma no encontrado: "}), 404


if __name__ == "__main__":
    app.run(host="0.0.0.0", debug=True, port=5000)
