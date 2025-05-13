<?php
include("includes/head.html");
include("includes/menu.php");

// Verificar si se ha pasado un ID de libro
if (!isset($_REQUEST['id']) || $_REQUEST['id'] == "") {
    header("location: index.php");
    exit;
}
?>

<div class="container">
  <div id="llibre-container"></div>
</div>

<script>
  function getParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  let id = getParam('id');
  let url = id ? `api/storebooks.php?id=${id}` : "api/storebooks.php?id=1";

  fetch(url)
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById("llibre-container");

      if (data) {
        const llibre = data;

        const div = document.createElement("div");
        div.className = "llibre";
        div.innerHTML = `
          <img src="${llibre.image}" alt="Imatge del llibre">
          <div class="llibre-info">
            <h4>${llibre.titol}</h4>
            <p class="autor">Autor: ${llibre.autor}</p>
            <p class="any">Any de publicació: ${llibre.any}</p>
            <p class="isbn">ISBN: ${llibre.isbn}</p>
            <p class="categoria">Categoria: <a href="veureLlibresCategoria.php?categoria=${encodeURIComponent(llibre.categoria)}">${llibre.categoria}</a></p>
            <p class="rating">Puntuació: ${llibre.rating.rate} (${llibre.rating.count} valoracions)</p>
          </div>
        `;
        container.appendChild(div);
      } else {
        container.innerHTML = "<p>Error al obtenir les dades de l'API.</p>";
      }
    })
    .catch(error => {
      document.getElementById("llibre-container").innerHTML =
        "<p>Error de connexió a l'API.</p>";
      console.error(error);
    });
</script>

<?php
include("includes/foot.html");
?>
