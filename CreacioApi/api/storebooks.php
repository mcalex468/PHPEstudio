<?php
include '../includes/errorHandler.proc.php';
include '../includes/dbConnect.proc.php';

// Peticions GET
if($_SERVER['$_REQUEST_METHOD'] == 'GET') {

    // Retornar totes les categories
    if(isset($_GET['categoria']) && $_GET['categoria'] === 'all'){
        $resultat = $db->query("SELECT DISTINCT(categoria) FROM llibres ORDER BY categoria");
        $categorias = [];
        while ($categoria = $resultat->fetchArray(SQLITE3_ASSOC)){
            $categorias[] = $categoria['categoria'];
        }
             //header('Content-Type: application/json');
            echo json_encode($categorias);
    }

    // Retornar tots els LLIBRES d'una CATEGORIA
    if(isset($_GET['categoria'])){
        $stmt = $db->prepare("SELECT * FROM llibres WHERE categoria = :cat ORDER BY titol");
        $stmt->bindValue(':cat', $_GET['categoria'], SQLITE3_TEXT);
        $result = $stmt->execute();
        $llibres = [];
        while ($llibres = $result->fetchArray(SQLITE3_ASSOC)){
            $llibres[] = [
                "id" => $llibres['id'],
                "titol" => $llibres['titol'],
                "autor" => $llibres['autor'],
                "any" => $llibres['any'],
                "categoria" => $llibres['categoria'],
                "isbn" => $llibres['isbn'],
                "rating" => [
                    "rate" => $llibres['rating.rate'],
                    "count" => $llibres['rating.count']
                ]
            ];
        }
        //header('Content-Type: application/json');
        echo json_encode($llibres);

    // Retornar un producte concret
    } else if(isset($_GET['id'])){
        $stmt = $db->prepare("SELECT * FROM llibres WHERE id = :id");
        $stmt->bindValue(':id',$_GET['id'],SQLITE3_TEXT);
        $result = $stmt->execute();
        $llibre = [];
        if ($llibre = $result->fetchArray(SQLITE3_ASSOC)){
            $llibre = [
                 "id" => $llibres['id'],
                "titol" => $llibres['titol'],
                "autor" => $llibres['autor'],
                "any" => $llibres['any'],
                "categoria" => $llibres['categoria'],
                "isbn" => $llibres['isbn'],
                "rating" => [
                    "rate" => $llibres['rating.rate'],
                    "count" => $llibres['rating.count']
                ]
            ];
        }
         //header('Content-Type: application/json');
        echo json_encode($llibre);
    } else {
        $result = $db->query("SELECT * FROM llibres ORDER BY titol");
        $llibres = [];
        while ($llibres = $result->fetchArray(SQLITE3_ASSOC)){
            $llibres[] = [
                "id" => $llibres['id'],
                "titol" => $llibres['titol'],
                "autor" => $llibres['autor'],
                "any" => $llibres['any'],
                "categoria" => $llibres['categoria'],
                "isbn" => $llibres['isbn'],
                "rating" => [
                    "rate" => $llibres['rating.rate'],
                    "count" => $llibres['rating.count']
                ]
            ];
        }
        //header('Content-Type: application/json');
        echo json_encode($llibres); 
    } 
}