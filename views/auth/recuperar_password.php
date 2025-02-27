<h1 class="nombre_pagina">Recuperar Contraseña</h1>
<p class="descripcion_pagina">Coloca tu nueva contraseña a continuación</p>
<?php 
include_once __DIR__ . "/../templates/alertas.php";  
?>

<?php if ($error) return; ?>
<form method="POST" class="formulario">

<div class="campo">
    <label for="password">Tu Nueva Contraseña</label>
    <input 
        type="password"
        id="password"
        name="password"
        placeholder="Tu Nueva Contraseña">
</div>
<input type="submit" class="boton" value="Guardar nueva Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear_cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>