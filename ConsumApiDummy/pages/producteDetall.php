<?php
include("../includes/header.html");
include("../includes/errorHandler.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); // Asegúrate que es un número
    $url = "https://dummyjson.com/products/$id";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && is_array($data)) {
        echo "<div class='product-detail-container'>";
        echo "<h2 class='product-title'>" . htmlspecialchars($data["title"]) . "</h2>";
        echo "<img src='" . htmlspecialchars($data["thumbnail"]) . "' alt='" . htmlspecialchars($data["title"]) . "' class='product-image'><br>";
        echo "<ul class='product-info-list'>";
        echo "<li><strong>Categoría:</strong> " . htmlspecialchars($data["category"]) . "</li>";
        echo "<li><strong>Descripción:</strong> " . htmlspecialchars($data["description"]) . "</li>";
        echo "<li><strong>Precio:</strong> $" . htmlspecialchars($data["price"]) . "</li>";
        echo "<li><strong>Valoración:</strong> " . htmlspecialchars($data["rating"]) . " / 5</li>";
        echo "<li><strong>Stock disponible:</strong> " . htmlspecialchars($data["stock"]) . "</li>";
        echo "</ul>";
        echo "<div class='text-center'>";
        echo "<a href='javascript:history.back()' class='back-button'>← Volver</a>"; // Para volver a la anterior
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>Error al obtener los datos del producto.</p>";
    }
} else {
    echo "<p>ID inválido.</p>";
}

include("../includes/footer.html");
?>
