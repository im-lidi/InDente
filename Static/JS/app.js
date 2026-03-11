// Buscar en tabla
function buscar() {
  let texto = document.getElementById("buscar").value.toLowerCase();
  let filas = document.querySelectorAll(".tabla tbody tr");

  filas.forEach(fila => {
    fila.style.display = fila.textContent.toLowerCase().includes(texto) ? "" : "none";
  });
}

// Buscar en tabla
function buscarpaci() {
  let texto = document.getElementById("buscarpaci").value.toLowerCase();
  let filas = document.querySelectorAll(".tablapaci tbody tr");

  filas.forEach(fila => {
    fila.style.display = fila.textContent.toLowerCase().includes(texto) ? "" : "none";
  });
}

// ===== MODAL =====
function abrirModal(id) {
  document.getElementById(id).classList.add("show");
}

function cerrarModal(id) {
  document.getElementById(id).classList.remove("show");
}

// Cerrar modal al hacer clic fuera
document.addEventListener("click", function(e) {
  if (e.target.classList.contains("modal-overlay")) {
    e.target.classList.remove("show");
  }
});