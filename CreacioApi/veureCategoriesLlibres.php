<?php
include("includes/head.html");
include("includes/menu.php");
?>

<div class="container">
  <h3 id="titol-categoria">Llibres de la categoria - ...</h3>
  <div id="llistat-llibres" class="llistat-llibres"></div>
</div>

<script>
  function getParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  let categoria = getParam('categoria');
  let url = "";

  // Si no hay categoría especificada, se cargan todos los libros
  if (!categoria || categoria === "totes") {
    categoria = "totes"; // para la categoría "totes" o si no hay categoría
    url = "api/storebooks.php";  // Endpoint para obtener todos los libros
  } else {
    url = "api/storebooks.php?category=" + encodeURIComponent(categoria);  // Endpoint para obtener libros por categoría
  }

  console.log(url);

  // Cambiar el título según la categoría
  document.getElementById("titol-categoria").innerText =
    "Llibres de la categoria - " + categoria.charAt(0).toUpperCase() + categoria.slice(1);

  // Hacer la petición a la API para obtener los libros
  fetch(url)
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById("llistat-llibres");

      if (Array.isArray(data)) {
        data.forEach(llibre => {
          const div = document.createElement("div");
          div.className = "llibre-mini";
          div.innerHTML = `
            <div><a href="veureLlibre.php?id=${llibre.id}">${llibre.titol}</a></div>
            <div class="autor">Autor: ${llibre.autor}</div>
            <div class="any">Any de publicació: ${llibre.any}</div>
            <div class="rating">Puntuació: ${llibre.rating.rate} (${llibre.rating.count})</div>
          `;
          container.appendChild(div);
        });
      } else {
        container.innerHTML = "<p>Error al obtenir les dades de l'API.</p>";
      }
    })
    .catch(error => {
      document.getElementById("llistat-llibres").innerHTML =
        "<p>Error de connexió a l'API.</p>";
      console.error(error);
    });

  // Cargar el menú
  fetch("includes/menu.php")
    .then(res => res.text())
    .then(html => document.getElementById("menu-container").innerHTML = html);

  // Cargar el footer
  fetch("includes/foot.html")
    .then(res => res.text())
    .then(html => document.getElementById("footer-container").innerHTML = html);
</script>

<?php
include("includes/foot.html");
?>
