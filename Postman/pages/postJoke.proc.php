<?php
// URL de la API
$url = "https://api101.up.railway.app/joke";

// Recoger los datos del formulario
$data = array(
    'author' => $_REQUEST['author'], // El autor del chiste
    'joke' => $_REQUEST['joke'],     // El texto del chiste
    'source' => $_REQUEST['source']  // La fuente (opcional)
);

// Inicializar CURL
$ch = curl_init($url);

// Configurar la solicitud POST
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Pasar los datos en formato JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Cabecera para indicar JSON
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Configurar para que CURL devuelva la respuesta

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Comprobar si hay errores en la solicitud CURL
if (curl_errno($ch)) {
    echo '❌ Error al realizar la solicitud: ' . curl_error($ch);
} else {
    // Decodificar la respuesta JSON
    $json_response = json_decode($response, true);
    echo "<pre>";
print_r($json_response);
echo "</pre>";


    if (isset($json_response['id'])) {
        // Redirigir a gestionJoke.php con el ID del chiste creado
        header("Location: gestionJoke.php");
        exit;
    } else {
        echo "❌ Chiste creado, pero no se recibió un ID válido.";
        echo "<pre>" . print_r($json_response, true) . "</pre>";
    }
}

// Cerrar la conexión cURL
curl_close($ch);
?>
