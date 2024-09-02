// Modal de Editar Estadísticas
var editStatsModal = document.getElementById("editStatsModal");
var openEditStatsBtn = document.getElementById("openEditStatsModal");
var closeEditStatsSpan = document.getElementsByClassName("modal-close")[0];
var cancelEditStatsBtn = document.getElementsByClassName("modal-cancelBtn")[0];

openEditStatsBtn.onclick = function() {
    editStatsModal.style.display = "block";
}

closeEditStatsSpan.onclick = function() {
    editStatsModal.style.display = "none";
}

cancelEditStatsBtn.onclick = function() {
    editStatsModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == editStatsModal) {
        editStatsModal.style.display = "none";
    }
}


// Modal de Usar Objeto
var usarObjetoModal = document.getElementById("usarObjetoModal");
var openUsarObjetoBtn = document.getElementById("openUsarModal");  // Asumiendo que este es el botón que abre el modal
var closeUsarObjetoSpan = document.getElementsByClassName("usarobjetomodal-close")[0];

openUsarObjetoBtn.onclick = function() {
    usarObjetoModal.style.display = "block";
}

closeUsarObjetoSpan.onclick = function() {
    usarObjetoModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == usarObjetoModal) {
        usarObjetoModal.style.display = "none";
    }
}


// Modal de Usar Habilidad
var usarHabilidadModal = document.getElementById("usarHabilidadModalDiv");
var openUsarHabilidadBtn = document.getElementById("usarHabilidadModal");
var closeUsarHabilidadSpan = document.getElementsByClassName("modal-habilidad-close")[0];

openUsarHabilidadBtn.onclick = function() {
    usarHabilidadModal.style.display = "block";
}

closeUsarHabilidadSpan.onclick = function() {
    usarHabilidadModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == usarHabilidadModal) {
        usarHabilidadModal.style.display = "none";
    }
}


// Modal de Crear Movimiento
var crearMovimientoModal = document.getElementById("crearMovimientoModal");
var openCrearMovimientoBtn = document.getElementById("usarMovimientoModal");
var closeCrearMovimientoSpan = document.getElementsByClassName("modal-close")[1]; // Modificado para manejar el segundo modal-close

openCrearMovimientoBtn.onclick = function() {
    crearMovimientoModal.style.display = "block";
}

closeCrearMovimientoSpan.onclick = function() {
    crearMovimientoModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == crearMovimientoModal) {
        crearMovimientoModal.style.display = "none";
    }
}


