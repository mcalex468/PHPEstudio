<?php
include("../includes/header.php");
include("../includes/errorHandler.proc.php");
?>

<h3 class="page-title">CATEGORIES</h3>

<?php
// URL para obtener las categorías de productos
$url = "https://dummyjson.com/products/categories"; 

// Realizamos la petición a la API
$response = file_get_contents($url);
$data = json_decode($response, true); 

// Comprobamos que los datos se recibieron correctamente
if ($data && is_array($data)) { // Verifica si la respuesta es un array
    echo "<div class='characters-grid'>";
    foreach ($data as $categoria) { // Iteramos sobre las categorías
        echo "<div class='character-card'>";
        echo "<h4><a href='productesCategoria.php?categoria=" . urlencode($categoria) . "'>" . htmlspecialchars($categoria) . "</a></h4>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Error al obtener datos de la API";
}

include("../includes/footer.php");
?>
