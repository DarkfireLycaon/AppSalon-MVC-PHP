<h1 class="nombre-pagina">Admin Panel</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>
<h2>Search appointments</h2>
<div class="busqueda">
<form action="POST" class="formulario"></form>
<div class="campo">
    <label for="fecha">date</label>
    <input type="date"
    id="fecha"
    name="fecha"
    value="<?php echo $fecha; ?>">
</div>
</div>
<?php if(count($citas) === 0){
    echo'<h2>There are no appointments on this day</h2>';
} ?>
<div id="citas-admin">
    <ul class="citas">


    <?php 
    $idCita = 0;
foreach ($citas as $key => $cita){
 if ($idCita !== $cita->id){
$total = 0;
 
 ?>
<li>
    <p>ID: <span><?php echo $cita->id ?></span></p>
    <p>Hour: <span><?php echo $cita->hora ?></span></p>
    <p>Customer: <span><?php echo $cita->cliente ?></span></p>
    <p>Email: <span><?php echo $cita->email ?></span></p>
    <p>Phone Number: <span><?php echo $cita->telefono ?></span></p>
    <h3>Services</h3>
    <?php
$idCita = $cita->id;
 } $total+= $cita->precio; // fin del if ?>
<p class="servicio"> <?php echo $cita->servicio . " " . $cita->precio ?></p>
<?php 
$actual = $cita->id;
$proximo = $citas[$key+1]->id ?? 0; 

if (esUltimo($actual, $proximo)){?>
 <p class="total">Total: <span>$<?php echo $total; ?></span></p>
 <form action="/api/eliminar" method="POST">
    <input type="hidden" name="id" value="<?php echo $cita->id;?>">
    <input type="submit" class="boton-eliminar" value="Delete">
 </form>
<?php } } //fin de foreach ?> 
</ul>
</div>
<?php 
$script = "<script src= 'build/js/buscador.js'></script>"

?>