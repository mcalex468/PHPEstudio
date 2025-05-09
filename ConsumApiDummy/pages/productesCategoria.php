<?php
include("../includes/header.php");
?>

<h3 class="page-title">PRODUCTES</h3>

<?php
// Obtener la categoría desde la URL
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

$url = "https://dummyjson.com/products/category/" . urlencode($categoria);

$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data && is_array($data) && isset($data['products'])) {
    echo "<div class='characters-grid'>";
    foreach ($data['products'] as $producte) { // Ya que accedemos a products 
        echo "<div class='character-card'>";
        echo "<img src='" . htmlspecialchars($producte["thumbnail"]) . "' alt='" . htmlspecialchars($producte["title"]) . "'>";
        echo "<h4><a href='detallProducte.php?id=" . urlencode($producte["id"]) . "'>" . htmlspecialchars($producte["title"]) . "</a></h4>";
        echo "<p>ID: " . htmlspecialchars($producte["id"]) . "</p>";
        echo "<p>Preu: $" . htmlspecialchars($producte["price"]) . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Error al obtenir productes de la categoria.";
}

include("../includes/footer.php");
?>
