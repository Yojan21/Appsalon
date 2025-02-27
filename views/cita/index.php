<h1 class="nombre_pagina">Crear Nueva Cita</h1>
<p class="descripcion_pagina">Elije tus servicios y coloca tus datos a continuación</p>

<div class="barra">
    <p>Hola: <?php echo $nombre ?? '' ?></p>

    <a class="boton" href="/logout">Cerrar sesion</a>
</div>

<div id="app">
    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso_1" class="seccion">
        <h2>Servicios</h2>
        <p class="text_center">Elije tus servicios a continuación</p>
        <div class="listado_servicios" id="servicios"></div>
    </div>

    <div id=paso_2 class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text_center">Coloca tus datos y fecha de tu cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre ?>"
                    disabled>

            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    id="fecha"
                    min="<?php echo date('Y-m-d') ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    type="time"
                    id="hora">
            </div>
        </form>
        <input type="hidden" id="id" value="<?php echo $id ?>">
    </div>

    <div id=paso_3 class="seccion contenido_resumen">
        <h2>Resumen</h2>
        <p class="text_center">Verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button 
            class="boton"
            id="anterior">&laquo; Anterior
        </button>
        <button 
            class="boton"
            id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php
    $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
    ";
?>