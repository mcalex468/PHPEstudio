<?php
$id = $_GET["id"]; // Obtienes el ID del chiste que se quiere actualizar
$url = "https://api101.up.railway.app/joke/$id"; // URL para acceder al chiste específico

// Recoger los datos del formulario, solo si fueron enviados
$data = array();

// Solo agregar al array los campos que fueron proporcionados
if (isset($_REQUEST['author']) && $_REQUEST['author'] !== '') {
    $data['author'] = $_REQUEST['author']; // Si se envió un autor, lo agregamos
}

if (isset($_REQUEST['joke']) && $_REQUEST['joke'] !== '') {
    $data['joke'] = $_REQUEST['joke']; // Si se envió un chiste, lo agregamos
}

if (isset($_REQUEST['source']) && $_REQUEST['source'] !== '') {
    $data['source'] = $_REQUEST['source']; // Si se envió una fuente, la agregamos
}

// Verificamos si se recibieron datos a actualizar
if (empty($data)) {
    echo "❌ No se han recibido datos para actualizar.";
    exit;
}

// Inicializar cURL
$ch = curl_init($url);

// Configurar la solicitud PATCH
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // Especificamos que es una solicitud PATCH
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Pasamos los datos en formato JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Cabecera para indicar JSON

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
