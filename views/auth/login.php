<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Login with your personal data</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" action="/" method="POST">


<div class="campo">
    <label for="email">Email</label>
<input type="email" id="email" placeholder="Your email" name="email">
</div>
<div class="campo">
<label for="password">Password</label>
<input type="password" id="password" placeholder="Your password" name="password" >
</div>
<input type="submit"  class="boton" value="Login">

</form>
<div class="acciones">
<a href="/crear-cuenta"> Still don't have an account? Create one</a>
<a href="/olvide">Did you forget your password?</a>

</div>