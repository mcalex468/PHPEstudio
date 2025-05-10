<?php
$id = $_GET["id"];  // Obtener el ID del chiste que se quiere editar

// URL de la API para actualizar el chiste con el ID
$url = "https://api101.up.railway.app/joke/$id";  // Agregar el ID en la URL para actualizar el chiste específico

// Recoger los datos del formulario
$data = array(
    'author' => $_REQUEST['author'], // El autor del chiste
    'joke' => $_REQUEST['joke'],     // El texto del chiste
    'source' => $_REQUEST['source']  // La fuente (opcional)
);

// Inicializar cURL
$ch = curl_init($url);

// Configurar la solicitud PUT
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  // Establecer el método como PUT
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  // Pasar los datos en formato JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  // Cabecera para indicar que se enviarán datos en JSON

// Configurar para que cURL devuelva la respuesta
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Comprobar si hay errores en la solicitud cURL
if (curl_errno($ch)) {
    echo '❌ Error al realizar la solicitud: ' . curl_error($ch);
} else {
    // Decodificar la respuesta JSON
    $json_response = json_decode($response, true);
    echo "✅ Chiste actualizado con éxito:<br>";
    echo "<pre>" . print_r($json_response, true) . "</pre>"; // Mostrar la respuesta
}

// Cerrar la conexión cURL
curl_close($ch);
?>
