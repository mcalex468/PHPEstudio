<?php
include("../includes/header.html");
include("../includes/errorHandler.proc.php");
?>

<h3 class="page-title">Categories</h3>

<?php
$url = "https://dummyjson.com/products/categories"; 
$response = file_get_contents($url);
$data = json_decode($response, true); 

if ($data && is_array($data)) {
    echo "<div class='category-grid'>";
    /*
    echo "<pre>";  // Vemos que devuelve la API
    print_r($data);
    echo "</pre>";
    */
    foreach ($data as $categoria) {
        echo "<div class='category-card'>";
        echo "<h4><a class='category-link' href='productesCategoria.php?categoria=" . urlencode($categoria["slug"]) . "'>" . htmlspecialchars($categoria["name"]) . "</a></h4>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p class='error-message'>Error al obtener datos de la API</p>";
}

include("../includes/footer.html");
?>
