<?php
include("../includes/header.php");
include("../includes/errorHandler.proc.php");

$url = "https://api101.up.railway.app/joke";

$response = file_get_contents($url);

$data = json_decode($response); // Devuelve un objeto

if ($data && is_object($data)) {
    echo "<h2>CHISTE DEL DÍA</h2>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> " . htmlspecialchars($data->id) . "</li>";
    echo "<li><strong>Author:</strong> " . htmlspecialchars($data->author) . "</li>";
    echo "<li><strong>Joke:</strong> " . htmlspecialchars($data->joke) . "</li>";
    echo "<li><strong>Source:</strong> " . htmlspecialchars($data->source) . "</li>";
    echo "</ul>";
} else {
    echo "❌ Error al obtener el chiste.";
}
?>
