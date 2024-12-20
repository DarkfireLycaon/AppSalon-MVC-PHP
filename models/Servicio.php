<?php
namespace Model;

class Servicio extends ActiveRecord{
    //base de datos configuracion
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args ['id'] ?? null;
        $this->nombre = $args ['nombre'] ?? '';
        $this->precio = $args ['precio'] ?? '';
    }
    public function validar(){
 if(!$this->nombre){
    self::$alertas['error'][] = 'The name of the service is a must';
 }
 if(!$this->precio){
    self::$alertas['error'][] = 'The price of the service is a must';
 }
 if(!is_numeric($this->precio)){
    self::$alertas['error'][] = 'The price is not valid';
 }
 return self::$alertas;
    }
}