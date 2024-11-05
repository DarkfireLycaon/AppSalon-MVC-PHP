<h1 class="nombre-pagina">Create Account</h1>
<p class="descripcion-pagina">

<?php 
include_once __DIR__ . "/../templates/alertas.php";
?>


     Fill the following form in order to create an account</p>
     <form action="/crear-cuenta" method="POST" class="formulario">
     
     <div class="campo">
        <label for="nombre">Name</label>
        <input type="text"
        id="nombre"
        name="nombre"
        placeholder="Your Name"
        value="<?php echo s($usuario ->$nombre);?>">
        
     </div>
         
     <div class="campo">
        <label for="apellido">Surname</label>
        <input type="text"
        id="apellido"
        name="apellido"
        placeholder="Your Surname"
        value="<?php echo s($usuario ->$apellido);?>">
     </div>
         
     <div class="campo">
        <label for="telefono">Phone Number</label>
        <input type="tel"
        id="telefono"
        name="telefono"
        placeholder="Your phone number"
        value="<?php echo s($usuario ->$telefono);?>">
     </div>
         
     <div class="campo">
        <label for="email">Email</label>
        <input type="email"
        id="email"
        name="email"
        placeholder="Your Email"
        value="<?php echo s($usuario ->$email);?>">
     </div>

     <div class="campo">
        <label for="password">Password</label>
        <input type="password"
        id="password"
        name="password"
        placeholder="Your Password"
        value="<?php echo s($usuario ->$password);?>">
     </div>

     <input type="submit" class="boton" value="Create account">

     </form>

     <div class="acciones">
<a href="/"> Do you have an account? Login</a>
<a href="/olvide">Did you forget your password?</a>

</div>
     