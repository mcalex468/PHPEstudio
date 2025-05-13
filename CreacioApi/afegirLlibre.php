<?php
include("includes/head.html");
include("includes/menu.php");
?>

<div class="container">
  <h3>AFEGIR NOU LLIBRE</h3>
  <form id="form-llibre">
    <label for="titol">Títol:</label><br>
    <input type="text" name="titol" id="titol" required><br><br>

    <label for="autor">Autor:</label><br>
    <input type="text" name="autor" id="autor" required><br><br>

    <label for="any">Any de publicació:</label><br>
    <input type="number" name="any" id="any" required><br><br>

    <label for="categoria">Categoria:</label><br>
    <input list="categories" name="categoria" id="categoria" required>
    <datalist id="categories"></datalist><br><br>

    <label for="isbn">ISBN:</label><br>
    <input type="text" name="isbn" id="isbn" required><br><br>

    <label for="rate">Valoració (0-5):</label><br>
    <input type="number" name="rate" id="rate" min="0" max="5" step="0.1" required><br><br>

    <label for="count">Nombre de valoracions:</label><br>
    <input type="number" name="count" id="count" min="0" required><br><br>

    <button type="submit">Afegir llibre</button>
  </form>

  <div id="resposta" style="margin-top:20px;"></div>
</div>

<script>
  // Carrega les categories al datalist
  fetch("api/storebooks.php?categoria=all")
    .then(response => response.json())
    .then(data => {
      const datalist = document.getElementById("categories");
      data.forEach(cat => {
        const opt = document.createElement("option");
        opt.value = cat;
        datalist.appendChild(opt);
      });
    })
    .catch(error => {
      console.error("Error carregant categories:", error);
    });

  // Envia el formulari amb JSON
  document.getElementById("form-llibre").addEventListener("submit", function(e) {
    e.preventDefault();

    const categoria = document.getElementById("categoria").value;

    const dades = {
      titol: document.getElementById("titol").value,
      autor: document.getElementById("autor").value,
      any: parseInt(document.getElementById("any").value),
      categoria: categoria,
      isbn: document.getElementById("isbn").value,
      "rating.rate": parseFloat(document.getElementById("rate").value),
      "rating.count": parseInt(document.getElementById("count").value)
    };

    fetch("api/storebooks.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(dades)
    })
    .then(response => response.json())
    .then(data => {
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
  });
</script>

<?php
include("includes/foot.html");
?>
