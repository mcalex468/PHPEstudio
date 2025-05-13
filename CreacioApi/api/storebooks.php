<?php
include '../includes/errorHandler.proc.php';
include '../includes/dbConnect.proc.php';

    // PETICIONS GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Obtenir categories uniques
    if (isset($_GET['categoria']) && $_GET['categoria'] === 'all') {
        $resultat = $db->query("SELECT DISTINCT categoria FROM llibres ORDER BY categoria");
        $categories = [];
        while ($row = $resultat->fetchArray(SQLITE3_ASSOC)) {
            $categories[] = $row['categoria'];
        }
        echo json_encode($categories);
        exit;
    }

    // Obtenir llibres per categoria
    if (isset($_GET['categoria'])) {
        $stmt = $db->prepare("SELECT * FROM llibres WHERE categoria = :cat ORDER BY titol");
        $stmt->bindValue(':cat', $_GET['categoria'], SQLITE3_TEXT);
        $result = $stmt->execute();
        $llibres = [];
        while ($llibre = $result->fetchArray(SQLITE3_ASSOC)) {
            $llibres[] = [
                "id" => $llibre['id'],
                "titol" => $llibre['titol'],
                "autor" => $llibre['autor'],
                "any" => $llibre['any'],
                "categoria" => $llibre['categoria'],
                "isbn" => $llibre['isbn'],
                "rating" => [
                    "rate" => $llibre['rating.rate'],
                    "count" => $llibre['rating.count']
                ]
            ];
        }
        echo json_encode($llibres);
        exit;

    // Obtenir llibre per ID
  } else if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM llibres WHERE id = :id");
    $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $llibre = [];
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
    } else {
        $llibre = ["error" => "Llibre no trobat"];
    }
    echo json_encode($llibre);
    exit;
    } else {

    // Obtenir tots els llibres
    $result = $db->query("SELECT * FROM llibres ORDER BY titol");
    $llibres = [];
    while ($llibre = $result->fetchArray(SQLITE3_ASSOC)) {
        $llibres[] = [
            "id" => $llibre['id'],
            "titol" => $llibre['titol'],
            "autor" => $llibre['autor'],
            "any" => $llibre['any'],
            "categoria" => $llibre['categoria'],
            "isbn" => $llibre['isbn'],
            "rating" => [
                "rate" => $llibre['rating.rate'],
                "count" => $llibre['rating.count']
            ]
        ];
    }
    echo json_encode($llibres);
}
    // PETICIÓ POST
}  else if($_SERVER['REQUEST_METHOD'] == 'POST') {
     $input = json_decode(file_get_contents('php://input'), true);

     if(isset($input['titol']) && isset($input['autor']) && isset($input['any']) && isset($input['categoria']) && isset($input['isbn']) && isset($input['rating.rate']) && isset($input['rating.count'])){
     $stmt = $db->prepare("INSERT INTO llibres (titol, autor, any, categoria, isbn, `rating.rate`, `rating.count`) 
                      VALUES (:titol, :autor, :any, :categoria, :isbn, :rate, :count)");

     $stmt->bindValue(':titol', $input['titol'], SQLITE3_TEXT);
     $stmt->bindValue(':autor', $input['autor'], SQLITE3_TEXT);
     $stmt->bindValue(':any', $input['any'], SQLITE3_INTEGER);
     $stmt->bindValue(':categoria', $input['categoria'], SQLITE3_TEXT);
     $stmt->bindValue(':isbn', $input['isbn'], SQLITE3_TEXT);
     $stmt->bindValue(':rate', $input['rating.rate'], SQLITE3_FLOAT);
     $stmt->bindValue(':count', $input['rating.count'], SQLITE3_INTEGER);

     if ($stmt->execute()) {
         http_response_code(201);
         echo json_encode(["success" => "Llibre afegit correctament"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al inserir el llibre"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Falten camps obligatoris"]);
    }
    // PETICIÓ PUT
} else if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $input = json_decode(file_get_contents('php://input'), true);

    // Verificar el ID
    if(!isset($input['id'])){
        http_response_code(400);
        echo json_encode(["error" => "Falta l'identificador del producte"]);
        exit;
     }
     // Obtenir el ID de la solicitud
     $llibre_id = $input['id'];

    if(isset($input['titol']) && isset($input['autor']) && isset($input['any']) && isset($input['categoria']) 
    && isset($input['isbn']) && isset($input['rating.rate']) && isset($input['rating.count'])) {
     // Preparacio consulta modificació Llibre
     $stmt = $db->prepare("UPDATE llibres SET titol = :titol, autor = :autor, any = :any , categoria = :categoria, isbn = :isbn, `rating.rate` = :rate, `rating.count` = :count WHERE id = :id");
     $stmt->bindValue(':id',$llibre_id, SQLITE3_INTEGER);
     $stmt->bindValue(':titol', $input['titol'], SQLITE3_TEXT);
     $stmt->bindValue(':autor', $input['autor'], SQLITE3_TEXT);
     $stmt->bindValue(':any', $input['any'], SQLITE3_INTEGER);
     $stmt->bindValue(':categoria', $input['categoria'], SQLITE3_TEXT);
     $stmt->bindValue(':isbn', $input['isbn'], SQLITE3_TEXT);
     $stmt->bindValue(':rate', $input['rating.rate'], SQLITE3_FLOAT);
     $stmt->bindValue(':count', $input['rating.count'], SQLITE3_INTEGER);
    
     if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["success" => "Llibre modificat correctament"]);
    } else {
      http_response_code(500);
      echo json_encode(["error" => "Error al modificar el llibre"]);
    }
    }
    // PETICIÓ PATCH
} else if($_SERVER['REQUEST_METHOD'] == 'PATCH'){
      $input = json_decode(file_get_contents('php://input'), true);

      if(!isset($input['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Falta l'identificador del llibre"]);
        exit;
    }

      $llibre_id = $input['id'];
      $setFields = [];
      $params = [];

      if(isset($input['titol'])) {
        $setFields[] = "titol = :titol";
        $params['titol'] = $input['titol'];
      }
      if(isset($input['autor'])) {
        $setFields[] = "autor = :autor";
        $params['autor'] = $input['autor'];
      }
      if(isset($input['any'])) {
        $setFields[] = "any = :any";
        $params['any'] = $input['any'];
      }
      if(isset($input['categoria'])) {
        $setFields[] = "categoria = :categoria";
        $params['categoria'] = $input['categoria'];
      }
      if(isset($input['isbn'])) {
        $setFields[] = "isbn = :isbn";
        $params['isbn'] = $input['isbn'];
      }

      if(isset($input['rating.rate'])) {
       $setFields[] = "`rating.rate` = :rate";
       $params['rate'] = $input['rating.rate'];
      }
      
      if(isset($input['rating.count'])) {
       $setFields[] = "`rating.count` = :count";
       $params['count'] = $input['rating.count'];
      }

      if(count($setFields) > 0){
        $sql = "UPDATE llibres SET " . implode(", ", $setFields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id',$llibre_id, SQLITE3_INTEGER);

        // Asignar els parametres dinamicament
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, is_numeric($value) ? SQLITE3_FLOAT : SQLITE3_TEXT);
        }

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => "Llibre modificat correctament"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al modificar el llibre"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "No s'han proporcionat dades per actualitzar"]);
      }

      // PETICIÓ DELETE
} else if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'] ?? null;
    if($id == null) {
        parse_str(file_get_contents("php://input"), $params);
        $id = $params['id'] ?? null;
    }
    if($id != null) {
       $stmt = $db->prepare("DELETE FROM llibres WHERE id = :id");
       $stmt->bindValue(':id',$id,SQLITE3_INTEGER);
       if($stmt->execute()){
        echo json_encode(["success" => "Llibre s'ha pogut eliminar"]);
       } else {
         http_response_code(500);
         echo json_encode(["error" => "No s'ha pogut eliminar el llibre"]);
       }
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Falta l'identificadror del llibre"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Petició no acceptada"]);
} 
?>
