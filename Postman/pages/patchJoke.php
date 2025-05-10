<?php
include("../includes/header.php");
include("../includes/errorHandler.proc.php");

// Obtener el ID del chiste desde la URL
$jokeId = $_GET['id'];

// URL de la API para obtener el chiste con el ID
$url = "https://api101.up.railway.app/joke/$jokeId";

// Realizar la solicitud GET para obtener el chiste
$response = file_get_contents($url);
$data = json_decode($response);

// Comprobar si se ha recibido el chiste
if ($data && is_object($data)) {
    // Si el chiste existe, cargar los datos en el formulario
    $author = htmlspecialchars($data->author);
    $joke = htmlspecialchars($data->joke);
    $source = htmlspecialchars($data->source);
} else {
    echo "❌ El chiste no se encontró.";
    exit;
}
?>

<h2>PUT JOKE</h2>
<form action="putJoke.proc.php" method="POST">
    <!-- Campo oculto con el ID del chiste -->
    <input type="hidden" name="id" value="<?php echo $jokeId; ?>">

    <label for="author">Autor:</label>
    <input type="text" name="author" id="author" value="<?php echo $author; ?>"><br>

    <label for="joke">Chiste:</label>
    <textarea name="joke" id="joke"><?php echo $joke; ?></textarea><br>

    <label for="source">Fuente:</label>
    <input type="text" name="source" id="source" value="<?php echo $source; ?>"><br>

    <input type="submit" value="Actualizar">
</form>
