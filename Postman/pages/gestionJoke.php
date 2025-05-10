<?php
include("../includes/header.php");
include("../includes/errorHandler.proc.php");

$url = "https://api101.up.railway.app/joke";

// Realizamos la solicitud a la API para obtener un chiste aleatorio
$response = file_get_contents($url);
$data = json_decode($response); // Devuelve un objeto

// Comprobamos si la respuesta es válida
if ($data && is_object($data)) {
    echo "<h2>CHISTE ALEATORIO</h2>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> " . htmlspecialchars($data->id) . "</li>";
    echo "<li><strong>Author:</strong> " . htmlspecialchars($data->author) . "</li>";
    echo "<li><strong>Joke:</strong> " . htmlspecialchars($data->joke) . "</li>";
    echo "<li><strong>Source:</strong> " . htmlspecialchars($data->source) . "</li>";
    echo "</ul>";

    // Almacenar el ID en una variable para usarlo en los botones
    $joke_id = $data->id;

    // Botones para modificar o eliminar
    echo '<a href="postJoke.php"><button>➕ Crear Nuevo Chiste</button></a>';
    echo '<a href="putJoke.php?id=' . $joke_id . '"><button>✏️ Modificar (PUT)</button></a>';
    echo '<a href="patchJoke.php?id=' . $joke_id . '"><button>✏️ Modificar (PATCH)</button></a>';
    echo '<a href="deleteJoke.proc.php?id=' . $joke_id . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este chiste?\');"><button>❌ Eliminar Chiste</button></a>';

} else {
    echo "❌ Error al obtener el chiste aleatorio.";
}
?>
