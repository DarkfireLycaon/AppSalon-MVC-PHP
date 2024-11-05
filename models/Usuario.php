<?php
namespace Model;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;

class Usuario extends ActiveRecord{
    //base de datos
    public static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        
        
    }
    //mensaje de validacion para crear una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'The name is a must';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'The surname is a must';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'The email is a must';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'The password is a must';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'The password should contain at least 6 characters';
        }



        return self::$alertas;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'You must write an email';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'You must write a password';
        }
        return self::$alertas;
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'You must write an email';
        }
        return self::$alertas;
    }
    public function comprobarPasswordVerificado($password){
        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado){
             self::$alertas['error'][] = 'Incorrect password Or account not confirmed';
        } else{
              return true;
        }
    }
    public function validarPassword(){
        if($this->password)
        {self::$alertas['error'][] = 'You must write a password';}
        if (strlen($this->password)<6){
            self::$alertas['error'][] = 'The password must contain at least 6 characters';

        }
        return self::$alertas;

    }
  
    public function existeUsuario(){
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' Limit 1";
        
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
    self::$alertas['error'][] = 'The user is already registered';
}
    return $resultado;
}
public function hashPassword(){
    $this->password = password_hash($this ->password, PASSWORD_BCRYPT);
}
public function CrearToken(){
    $this->token = uniqid();
}
}