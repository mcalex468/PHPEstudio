<?php
include("includes/head.html");
include("includes/menu.php");
?>
<div class="container">
  <h3 id="titol-categoria">
    GESTIÓ DE LLIBRES
    <a href="afegirLlibre.php" class="btn btn-afegir">+ Afegir llibre</a>
  </h3>
  <div id="llistat-llibres" class="llistat-productes"></div>
</div>

<script>
  function getParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  function eliminarLlibre(id) {
    if (confirm("Segur que vols eliminar aquest llibre?")) {
      fetch(`api/storebooks.php?id=${id}`, {
        method: "DELETE"
      })
      .then(res => res.json())
      .then(data => {
        if (!data.succes && !data.success) {
          alert("Error: " + (data.error || "No s'ha pogut eliminar"));
        } else {
          location.reload();
        }
      })
      .catch(err => {
        console.error("Error eliminant:", err);
        alert("Error de connexió");
      });
    }
  }

  const categoria = getParam('categoria');
  let url = "api/storebooks.php";

  if (categoria) {
    url += `?categoria=${encodeURIComponent(categoria)}`;
    document.getElementById("titol-categoria").innerHTML = `
      LLIBRES DE LA CATEGORIA: ${categoria.toUpperCase()}
      <a href="afegirLlibre.php" class="btn btn-afegir">+ Afegir llibre</a>
    `;
  }

  fetch(url)
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById("llistat-llibres");

      if (Array.isArray(data)) {
        if (data.length === 0) {
          container.innerHTML = "<p>No hi ha llibres en aquesta categoria.</p>";
          return;
        }

        data.forEach(llibre => {
          const div = document.createElement("div");
          div.className = "producte-mini";
          div.innerHTML = `
            <div class="title"><strong>${llibre.titol}</strong></div>
            <div>Autor: ${llibre.autor}</div>
            <div>Any: ${llibre.any}</div>
            <div>Categoria: ${llibre.categoria}</div>
            <div>ISBN: ${llibre.isbn}</div>
            <div class="rating">Rating: ${llibre.rating.rate} (${llibre.rating.count})</div>
            <div class="accio-producte">
              <button onclick="location.href='modificarLlibre.php?id=${llibre.id}'">Modificar</button>
              <button onclick="eliminarLlibre(${llibre.id})">Eliminar</button>
            </div>
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
</script>

<?php
include("includes/foot.html");
?>
