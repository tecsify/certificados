<?php
// Archivo: certificado.php

// URL del endpoint de la API
$apiUrl = 'http://backend:5000/backend/certificado_por_id';
$diplomaUrl = 'http://backend:5000/backend/diploma/';

// Obtén el UUID desde la URL
$uuid = $_GET['uuid'];

// Agrega el UUID a la URL de la API
$apiUrl .= '/' . $uuid;

// Realiza la solicitud GET a la API
$response = file_get_contents($apiUrl);

if ($response === false) {
    // Error al conectarse a la API
    echo "Error al conectarse a la API.";
} else {
    $data = json_decode($response, true);

    if (isset($data['message'])) {
        // Certificado no encontrado
        echo "Certificado no encontrado.";
    } else {
        // Certificado encontrado, muestra los datos
        echo "<h2>Datos del Certificado:</h2>";
        echo "<p>ID del Certificado: " . $data['certificados'][0]['certificado_id'] . "</p>";
        echo "<p>Nombre del Certificado: " . $data['certificados'][0]['nombre_certificado'] . "</p";
        
        // Formatea la fecha
        $fecha = new DateTime($data['certificados'][0]['fecha_certificado']);
        $fechaFormateada = $fecha->format('d/m/Y');
        
        echo "<p>Fecha de Certificado: " . $fechaFormateada . "</p>";
        echo "<p>Impartido por: " . $data['certificados'][0]['certificado_impartido'] . "</p>";
        echo "<p>Evento: " . $data['certificados'][0]['evento'] . "</p>";

        // Solicita la imagen del diploma
        $imageData = file_get_contents($diplomaUrl . $uuid);

        // Convierte los datos de la imagen a base64
        $base64Image = base64_encode($imageData);

        // Construye una URL de datos
        $dataUrl = "data:image/jpeg;base64," . $base64Image;

        // Muestra la imagen dentro de una etiqueta <img>
        echo "<img src='$dataUrl' alt='Diploma' />";
    }
}
?>
