<h1 class="nombre_pagina">Login</h1>
<p class="descripcion_pagina">Inicia sesion con tus datos</p>
<?php

include_once __DIR__ . '/../templates/alertas.php';

?>
<form method="POST" action="/" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu Contraseña"
            name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión"> 
</form>

<div class="acciones">
    <a href="/crear_cuenta">¿Aún no tienes una cuenta? Crea una</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>