let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id:'',
    nombre : '',
    fecha :'',
    hora : '',
    servicios : []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion();
    tabs(); //Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    //Muestra todos lo servicios en la seccion Servicios y selecciona
    consultarAPI();

    //Llenando el objeto de cita con nombre, fecha y hora
    idCliente();
    nombreCliente(); 
    seleccionaFecha();
    seleccionarHora();

    //Confirmacion de la informacion de la cita en el resumen
    mostrarResumen();
}

function mostrarSeccion(){

    //Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso_${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    //Quita la clase actual al anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        })
    });

    console.log(botones);
}

function botonesPaginador(){
    const paginaSiguiente = document.querySelector('#siguiente');
    const paginaAnterior = document.querySelector('#anterior');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click', function(){
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click', function(){
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

async function consultarAPI(){
    try{
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
        
    }catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach( servicio => {
        const {id, nombre, precio} = servicio;
        
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre_servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio_servicio');
        precioServicio.textContent = precio;

        const serviciodiv = document.createElement('DIV');
        serviciodiv.classList.add('servicio');
        serviciodiv.dataset.idServicio = id;

        serviciodiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        serviciodiv.appendChild(nombreServicio);
        serviciodiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(serviciodiv);
    })
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;
    //Identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    
    //comprobar si un servicio ya fue agregado
    if(servicios.some(agregado => agregado.id === id )){
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    }else{
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}

function idCliente(){
    cita.id = document.querySelector('#id').value;
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionaFecha(){
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input', function(e){
        
        const dia = new Date(e.target.value).getUTCDay();

        if([6, 0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitimos', 'error', '.formulario');
        }else{
            cita.fecha = e.target.value
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(":");

        if(hora[0] > 18 || hora[0] < 9){
            e.target.value = '';
            mostrarAlerta('Horario valido solo entre 9 y 18 hrs', 'error', '.formulario');
        }else{
            cita.hora = e.target.value
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, tiempo = true){

    //Previene que se genera mas de 1 alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    };

    //Generacion de la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    const formulario = document.querySelector(elemento);
    formulario.appendChild(alerta);

    if(tiempo){
        //Eliminar la alerta despues de 3 segundos
        setTimeout(() =>{
            alerta.remove();
        }, 3000);
    }
    
    
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido_resumen');

    //Limpiar el contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('Debes elegir por lo menos un servicio, fecha u hora', 'error', '.contenido_resumen', false);
        return;
    }

    //Formatear el div de resumen
    const {nombre, fecha, hora, servicios} = cita;

    //Heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    //Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor_servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;


        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    //Heading para servicios en resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;


    //Formatear la fecha en español
    const fechaObj =  new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-CO', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} hrs`;

    //Boton para Crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);

}

async function reservarCita(){
    const datos = new FormData();
    datos.append('nombre', 'juan');
}