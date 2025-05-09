<?php
include("../includes/header.html");
include("../includes/errorHandler.proc.php");
?>

<h3 class="page-title">Productes</h3>

<?php
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$url = "https://dummyjson.com/products/category/" . urlencode($categoria);
$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data && is_array($data) && isset($data['products'])) {
    echo "<div class='product-grid'>";
    foreach ($data['products'] as $producte) {
        echo "<div class='product-card'>";
        echo "<img class='product-img' src='" . htmlspecialchars($producte["thumbnail"]) . "' alt='" . htmlspecialchars($producte["title"]) . "'>";
        echo "<h4 class='product-title'><a class='product-link' href='producteDetall.php?id=" . urlencode($producte["id"]) . "'>" . htmlspecialchars($producte["title"]) . "</a></h4>";
        echo "<p class='product-id'>ID: " . htmlspecialchars($producte["id"]) . "</p>";
        echo "<p class='product-price'>Preu: $" . htmlspecialchars($producte["price"]) . "</p>";
        echo "</div>";
    }
    echo "<a href='javascript:history.back()' class='back-link'>← Volver</a>"; // Para volver a la anterior
    echo "</div>";
} else {
    echo "<p class='error-message'>Error al obtenir productes de la categoria.</p>";
}

include("../includes/footer.html");
?>
