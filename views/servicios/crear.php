<h1 class="nombre_pagina">Nuevo Servicio</h1>
<p class="descripcion_pagina">Completa todos los campos para crear un nuevo servicio</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';  
    include_once __DIR__ . '/../templates/alertas.php'; 
?>

<form action="/servicios/crear" method="post" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>