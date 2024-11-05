<?php
namespace Controllers;


use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController {
    public static function login(Router $router){
        $alertas = [];
 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
              $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                // comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    //verificar password
                  if  ($usuario->comprobarPasswordVerificado($auth->password)){
                    //autenticar usuario
                    session_start();
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    //redireccionamiento
                    if($usuario->admin === "1"){
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header("Location: /admin");

                    } else{
                        header("Location: /cita");
                    }

                    debuguear($_SESSION);


                  }

                } else{
                    Usuario::setAlerta('error', 'User not found');
                }
            }
        }
        $alertas = Usuario::getAlertas();
       $router->render('auth/login', [
        'alertas' =>$alertas
       ]);
    }
    public static function logout(){
session_start();

$_SESSION = [];

header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
           $alertas = $auth->validarEmail();

                if(empty($alertas)){
                    $usuario = Usuario::where('email', $auth->email);
                    if($usuario && $usuario->confirmado === "1"){
                        //generar token
                        $usuario->CrearToken();
                        $usuario->guardar();
                        //enviar email
                        $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                        $email->enviarInstrucciones();

                        //alerta exito
                        Usuario::setAlerta('exito', 'Check your email');
    
                    } else{
                        Usuario::setAlerta('error', 'The user is not confirmed or does not exists');
                        
    
    
                    }
                }
            }
    
        $alertas = usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas' =>$alertas,
        ]);
 
    }
    public static function recuperar(Router $router){
        $alertas=[];
        $token = s($_GET['token']);
        $error = False;

        //buscar usuario por su token
        $usuario =  Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Not valid token');
            $error = TRUE;

        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
           $alertas = $password ->validarPassword();

           if(!empty($alertas)){
            $usuario->password = null;
            $usuario->password = $password->password;
            $usuario-> hashPassword();
            $usuario->token = null;

            $resultado = $usuario->guardar();
            if($resultado){
                header('Location: /');
            }

           }
        }


        $router->render('auth/recuperar-password', [
            'alertas'=>$alertas,
            'error'=>$error,
        ]);
    }
    public static function crear(Router $router){
        $usuario = new Usuario;
        //alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario-> sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            
            //revisar que la alerta este vacio
            if(empty($alertas)){
                //verificar si existe el usuario
               $resultado = $usuario->existeUsuario();

               if($resultado->num_rows){
                $alertas = Usuario::getAlertas();
               } else{
                //hashear el password
                $usuario->hashPassword();

                //generar token unico
                $usuario->CrearToken();

                //enviar el email
                $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    // crear usuario
                    $resultado = $usuario->guardar();
                    if ($resultado){
                        header('Location: /mensaje');
                    }
               }
            }
        }
        $router ->render('auth/crear-cuenta', [
          'usuario' =>$usuario,
          'alertas' =>$alertas,
        ]);

    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario =  Usuario::where('token', $token);

        if(empty($usuario)){
            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Invalid Token');
        } else{
             $usuario->confirmado = '1';
             $usuario->token = '';
             $usuario->guardar();
             Usuario::setAlerta('exito', 'Account verified successfully');
        }
        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar-cuenta",[
           'alertas' => $alertas
        ]);
    }
}