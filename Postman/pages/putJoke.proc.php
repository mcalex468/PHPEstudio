<?php
$id = $_POST["id"];

$url = "https://api101.up.railway.app/joke/$id";

$data = array(
    'author' => $_REQUEST['author'],
    'joke' => $_REQUEST['joke'],
    'source' => $_REQUEST['source']
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, true); // para debug

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo '❌ Error al realizar la solicitud: ' . curl_error($ch);
} else {
    $json_response = json_decode($response, true);
    echo "✅ Chiste actualizado con éxito:<br>";
    echo "<pre>" . print_r($json_response, true) . "</pre>";
    echo "<pre>Respuesta cruda:\n$response</pre>";
}

curl_close($ch);
?>
