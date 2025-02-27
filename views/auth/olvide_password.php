<h1 class="nombre_pagina">Olvidaste tu password</h1>
<p class="descripcion_pagina">Llena el formulario para restablecer tu contraseña</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";  
?>

<form method="POST" action="/olvide" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email" 
            name="email"
            placeholder="Tu Email">
    </div>
    <input type="submit" class="boton" value="Enviar información"> 
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear_cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>