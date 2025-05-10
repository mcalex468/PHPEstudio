<?php
include '../includes/errorHandler.proc.php';
include '../includes/dbConnect.proc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Obtener categorías únicas
    if (isset($_GET['categoria']) && $_GET['categoria'] === 'all') {
        $resultat = $db->query("SELECT DISTINCT categoria FROM llibres ORDER BY categoria");
        $categorias = [];
        while ($row = $resultat->fetchArray(SQLITE3_ASSOC)) {
            $categorias[] = $row['categoria'];
        }
        echo json_encode($categorias);
        exit;
    }

    // Obtener libros por categoría
    if (isset($_GET['categoria'])) {
        $stmt = $db->prepare("SELECT * FROM llibres WHERE categoria = :cat ORDER BY titol");
        $stmt->bindValue(':cat', $_GET['categoria'], SQLITE3_TEXT);
        $result = $stmt->execute();
        $llibres = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $llibres[] = [
                "id" => $row['id'],
                "titol" => $row['titol'],
                "autor" => $row['autor'],
                "any" => $row['any'],
                "categoria" => $row['categoria'],
                "isbn" => $row['isbn'],
                "rating" => [
                    "rate" => $row['rating.rate'],
                    "count" => $row['rating.count']
                ]
            ];
        }
        echo json_encode($llibres);
        exit;
    }

    // Obtener libro por ID
    if (isset($_GET['id'])) {
        $stmt = $db->prepare("SELECT * FROM llibres WHERE id = :id");
        $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
        $result = $stmt->execute();
        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $llibre = [
                "id" => $row['id'],
                "titol" => $row['titol'],
                "autor" => $row['autor'],
                "any" => $row['any'],
                "categoria" => $row['categoria'],
                "isbn" => $row['isbn'],
                "rating" => [
                    "rate" => $row['rating.rate'],
                    "count" => $row['rating.count']
                ]
            ];
            echo json_encode($llibre);
        } else {
            echo json_encode(["error" => "Llibre no trobat"]);
        }
        exit;
    }

    // Obtener todos los libros
    $result = $db->query("SELECT * FROM llibres ORDER BY titol");
    $llibres = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $llibres[] = [
            "id" => $row['id'],
            "titol" => $row['titol'],
            "autor" => $row['autor'],
            "any" => $row['any'],
            "categoria" => $row['categoria'],
            "isbn" => $row['isbn'],
            "rating" => [
                "rate" => $row['rating.rate'],
                "count" => $row['rating.count']
            ]
        ];
    }
    echo json_encode($llibres);
}
?>
