FROM python:3.8-slim

# Establece el directorio de trabajo en /backend
WORKDIR /backend

# Copia el archivo requirements.txt al contenedor
COPY requirements.txt requirements.txt

# Instala las dependencias definidas en requirements.txt
RUN pip install -r requirements.txt

COPY . .
EXPOSE 5000

# Define el comando a ejecutar cuando el contenedor se inicie
CMD ["python", "main.py"]