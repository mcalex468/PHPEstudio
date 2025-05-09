<?php
include("../includes/header.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); // Asegúrate que es un número
    $url = "https://dummyjson.com/products/$id";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && is_array($data)) {
        echo "<div class='character-detail-container'>";
        echo "<h2>" . htmlspecialchars($data["title"]) . "</h2>";
        echo "<img src='" . htmlspecialchars($data["thumbnail"]) . "' alt='" . htmlspecialchars($data["title"]) . "' style='max-width:200px;'><br>";
        echo "<ul>";
        echo "<li><strong>Categoría:</strong> " . htmlspecialchars($data["category"]) . "</li>";
        echo "<li><strong>Descripción:</strong> " . htmlspecialchars($data["description"]) . "</li>";
        echo "<li><strong>Precio:</strong> $" . htmlspecialchars($data["price"]) . "</li>";
        echo "<li><strong>Valoración:</strong> " . htmlspecialchars($data["rating"]) . " / 5</li>";
        echo "<li><strong>Stock disponible:</strong> " . htmlspecialchars($data["stock"]) . "</li>";
        echo "</ul>";
        echo "<div class='text-center'>";
        echo "<a href='javascript:history.back()' class='back-link'>← Volver</a>"; // Para volver a la anterior
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>Error al obtener los datos del producto.</p>";
    }
} else {
    echo "<p>ID inválido.</p>";
}

include("../includes/footer.php");
?>
