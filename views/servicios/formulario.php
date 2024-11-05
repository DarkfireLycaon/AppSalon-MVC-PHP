<div class="campo">
    <label for="nombre">Name</label>
    <input 
    type="text"
     name="nombre" id="nombre" 
    placeholder="Service Name" 
    value="<?php echo $servicio->nombre; ?>">

</div>
<div class="campo">
    <label for="precio">Price</label>
    <input type="number"
     name="precio"
      id="precio"
       placeholder="Service Price"
       value="<?php echo $servicio->precio;?>">

</div>