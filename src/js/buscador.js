document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){
    buscarPorFecha();
}

function buscarPorFecha(){
    const fechainput = document.querySelector('#fecha');
    fechainput.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;

        window.location = `?fecha=${fechaSeleccionada}`;
    });
}