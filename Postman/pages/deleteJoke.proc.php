<?php
// Verifica si se ha enviado el ID a eliminar
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id']; // Obtener el ID a eliminar

    // URL de la API para eliminar el chiste por su ID
    $url = "https://api101.up.railway.app/joke/$id";

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar la solicitud DELETE
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Usamos DELETE
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Cabecera para indicar JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);

    // Comprobar si hay errores en la solicitud cURL
    if (curl_errno($ch)) {
        echo '❌ Error al realizar la solicitud: ' . curl_error($ch);
    } else {
        // Decodificar la respuesta
        $json_response = json_decode($response, true);
        echo "✅ Chiste eliminado con éxito.<br>";
        // Redirigir o mostrar el mensaje de éxito
        echo "<pre>" . print_r($json_response, true) . "</pre>";
    }

    // Cerrar la conexión cURL
    curl_close($ch);
} else {
    echo "❌ Debes proporcionar un ID válido para eliminar el chiste.";
}
?>
