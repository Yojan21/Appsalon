<h1 class="nombre_pagina">Actualizar Servicio</h1>
<p class="descripcion_pagina">Modifica los valores del formulario</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';  
    include_once __DIR__ . '/../templates/alertas.php'; 
?>

<form method="post" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Actualizar Servicio">
</form>