<h1 class="nombre-pagina">Recover Passsword</h1>
<p class="descripcion-pagina"> Write your new password</p>

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>
<?php if($error) return;?>
<form class="formulario" method="POST">
<div class="campo">
    <label for="password">Password</label>
    <input type="password"
    id="password"
    name="password"
    placeholder="Your new password"
    />
</div>
<input type="submit" class="boton" value="Save new password">

</form>

<div class="acciones">
    <a href="/">¿Do you have an account? Login</a>
    <a href="/crear-cuenta">Still dont have an account? Create one </a>
</div>