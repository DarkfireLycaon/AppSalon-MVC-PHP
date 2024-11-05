<div class="barra">
    <p>Hello <?php echo $nombre ?? '' ?></p>
    
    <a href="/logout" class="boton">Log out</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>
<div class="barra-servicios">
    <a href="/admin" class="boton">See appointments</a>
    <a href="/servicios" class="boton"> See services</a>
    <a href="/servicios/crear" class="boton">New Services</a>
</div>

<?php } ?>