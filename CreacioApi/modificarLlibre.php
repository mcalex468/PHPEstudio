<?php
include("includes/head.html");
include("includes/menu.php");
include("includes/errorHandler.proc.php");
include("includes/dbConnect.proc.php");

if (!isset($_GET['id'])) {
    die("ID no vàlid o no proporcionat.");
}
$book_id = $_GET['id'];  

$stmt = $db->prepare("SELECT * FROM llibres WHERE id = :id");
$stmt->bindValue(':id', $book_id, SQLITE3_INTEGER);
$result = $stmt->execute();

$llibre = $result->fetchArray(SQLITE3_ASSOC);

if (!$llibre) {
    die("No s'ha trobat el llibre amb ID: " . htmlspecialchars($book_id));
}
?>

<div class="container">
  <h3>MODIFICAR LLIBRE</h3>

  <form id="form-llibre">
    <input type="hidden" id="book_id" value="<?php echo $llibre['id']; ?>">

    <label for="titol">Nom:</label><br>
    <input type="text" name="titol" id="titol" value="<?php echo $llibre['titol']; ?>" required><br><br>

    <label for="autor">Autor:</label><br>
    <input type="text" name="autor" id="autor" value="<?php echo $llibre['autor']; ?>" required><br><br>

    <label for="any">Any de publicació:</label><br>
    <input type="number" name="any" id="any" value="<?php echo $llibre['any']; ?>" required><br><br>

    <label for="categoria">Categoria:</label><br>
    <input list="categories" name="categoria" id="categoria" value="<?php echo $llibre['categoria']; ?>" required>
    <datalist id="categories"></datalist><br><br>

    <label for="isbn">ISBN:</label><br>
    <input type="text" name="isbn" id="isbn" value="<?php echo $llibre['isbn']; ?>" required><br><br>

    <label for="rating">Valoració:</label><br>
    <input type="number" name="rating" id="rating" value="<?php echo $llibre['rating.rate']; ?>" step="0.1" min="0" max="5" required><br><br>

    <label for="rating_count">Número de valoracions:</label><br>
    <input type="number" name="rating_count" id="rating_count" value="<?php echo $llibre['rating.count']; ?>" required><br><br>

    <button type="submit">Modificar llibre</button>
  </form>

  <div id="resposta" style="margin-top:20px;"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("El DOM ha sido completamente cargado");

    // Cargar las categorías en el datalist
    fetch("api/storebooks.php?categoria=all")  // Cambié el endpoint a 'storebooks.php'
      .then(response => response.json())
      .then(data => {
        console.log("Respuesta de la API para categorías:", data);  // Ver qué devuelve la API

        const datalist = document.getElementById("categories");
        if (datalist) {
          console.log("Cargando categorías...");

          if (Array.isArray(data)) {
            data.forEach(cat => {
              const opt = document.createElement("option");
              opt.value = cat;
              datalist.appendChild(opt);
            });
            console.log("Categorías cargadas correctamente en el datalist.");
          } else {
            console.error("Los datos no son un array válido para las categorías:", data);
          }
        } else {
          console.error("No se encontró el datalist con id 'categories'");
        }
      })
      .catch(error => {
        console.error("Error cargando categorías:", error);
      });

    // Enviar el formulario con JSON
    document.getElementById("form-llibre").addEventListener("submit", function(e) {
      e.preventDefault();

      const categoria = document.getElementById("categoria").value;
      const book_id = document.getElementById("book_id").value;

      // Obtener los valores originales del libro
      const originalBook = <?php echo json_encode($llibre); ?>;

      // Obtenemos los datos que el usuario ha cambiado (FORMULARIO)
      const dades = {
        id: book_id, 
        titol: document.getElementById("titol").value,
        autor: document.getElementById("autor").value,
        any: parseInt(document.getElementById("any").value),
        categoria: document.getElementById("categoria").value,
        isbn: document.getElementById("isbn").value,
        rating: {
          rate: parseFloat(document.getElementById("rating").value),
          count: parseInt(document.getElementById("rating_count").value)
        }
      };

      // Comprobación de los datos para ver si han cambiado
      console.log("Datos del formulario: ", dades);
      console.log("Libro original: ", originalBook);

      let method;
      if (
        dades.titol !== originalBook.titol ||
        dades.autor !== originalBook.autor ||
        dades.any !== originalBook.any ||
        dades.categoria !== originalBook.categoria ||
        dades.isbn !== originalBook.isbn ||
        dades.rating.rate !== originalBook['rating.rate'] ||
        dades.rating.count !== originalBook['rating.count']
      ) {
        // Si hay cambios, determinar si es PUT o PATCH
        if (
          dades.titol !== originalBook.titol &&
          dades.autor !== originalBook.autor &&
          dades.any !== originalBook.any &&
          dades.categoria !== originalBook.categoria &&
          dades.isbn !== originalBook.isbn &&
          dades.rating.rate !== originalBook['rating.rate'] &&
          dades.rating.count !== originalBook['rating.count']
        ) {
          method = 'PUT';  // Si todos los campos han cambiado, usamos PUT
        } else {
          method = 'PATCH';  // Si solo algunos campos han cambiado, usamos PATCH
        }
      } else {
        // Si no hay cambios
        document.getElementById("resposta").innerHTML = "<p style='color: red;'>No s'han realitzat canvis.</p>";
        console.log("No hay cambios en los datos");
        return; // No enviar la solicitud
      }

      // Verificar si el elemento "resposta" existe
      const resposta = document.getElementById("resposta");
      if (resposta) {
        console.log("Enviando solicitud con método:", method);
        fetch("api/storebooks.php", { 
          method: method,
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(dades)  // El cuerpo incluye todos los datos, incluyendo el ID
        })
        .then(response => response.json())
        .then(data => {
          console.log("Respuesta de la API:", data);  // Agregar esto para ver la respuesta
          if (data.success) {
            window.location.href = `veureCategoriesLlibres.php?categoria=${encodeURIComponent(categoria)}`;
          } else {
            document.getElementById("resposta").innerHTML = `<p style="color: red;">${data.error}</p>`;
          }
        })
        .catch(error => {
          console.error("Error enviant dades:", error);
          document.getElementById("resposta").innerHTML = `<p style="color: red;">Error inesperat</p>`;
        });
      } else {
        console.error("El elemento con id 'resposta' no se encontró.");
      }
    });
});
</scri
