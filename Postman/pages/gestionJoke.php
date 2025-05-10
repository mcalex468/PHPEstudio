<?php include("header.php"); ?>
<h2>Gestión de Chistes</h2>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $url = "https://api101.up.railway.app/joke/$id";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && isset($data['id'])) {
        echo "<h3>📝 Chiste creado:</h3>";
        echo "<ul>";
        echo "<li><strong>ID:</strong> " . htmlspecialchars($data["id"]) . "</li>";
        echo "<li><strong>Author:</strong> " . htmlspecialchars($data["author"]) . "</li>";
        echo "<li><strong>Joke:</strong> " . htmlspecialchars($data["joke"]) . "</li>";
        echo "<li><strong>Source:</strong> " . htmlspecialchars($data["source"]) . "</li>";
        echo "</ul>";
    } else {
        echo "❌ No se pudo obtener el chiste con ID $id.";
    }
}
?>

<!-- Botones -->
<a href="postJoke.php"><button>➕ Crear Nuevo Chiste</button></a>

<?php if (isset($id)): ?>
    <a href="putJoke.php?id=<?= $id ?>"><button>✏️ Modificar (PUT)</button></a>
    <a href="patchJoke.php?id=<?= $id ?>"><button>✏️ Modificar (PATCH)</button></a>
    <a href="deleteJoke.proc.php?id=<?= $id ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este chiste?');">
        <button>❌ Eliminar Chiste</button>
    </a>
<?php endif; ?>
