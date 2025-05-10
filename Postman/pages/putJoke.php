<?php
include("../includes/header.php");
include("../includes/errorHandler.proc.php");

$jokeId = $_GET['id'];
$url = "https://api101.up.railway.app/joke/$jokeId";
$response = file_get_contents($url);
$data = json_decode($response);

if ($data && is_object($data)) {
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
    <input type="hidden" name="id" value="<?php echo $jokeId; ?>">

    <label for="author">Autor:</label>
    <input type="text" name="author" id="author" value="<?php echo $author; ?>" required><br>

    <label for="joke">Chiste:</label>
    <textarea name="joke" id="joke" required><?php echo $joke; ?></textarea><br>

    <label for="source">Fuente:</label>
    <input type="text" name="source" id="source" value="<?php echo $source; ?>" required><br>

    <input type="submit" value="Actualizar">
</form>
