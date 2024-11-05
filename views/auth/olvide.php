<h1 class="nombre-pagina">Forgot Password</h1>
<p class="descripcion-pagina">Recover your password rewriting your email in the following form</p>
<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>
<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" 
        name="email" 
        id="email"
        placeholder="Your email">
    </div>
    <input type="submit" class="boton" value="Send instructions">
</form>
<div class="acciones">
<a href="/"> Do you have an account? Login</a>
<a href="/crear-cuenta">Still don't have an account?</a>

</div>