<?php 
namespace Classes;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarConfirmacion(){
        //crear objeto de email
        $mail = new PHPMailerPHPMailer();
$mail->isSMTP();
$mail->Host = $_ENV['EMAIL_HOST'];
$mail->SMTPAuth = true;
$mail->Port = $_ENV['EMAIL_PORT'];
$mail->Username = $_ENV['EMAIL_USER'];
$mail->Password = $_ENV['EMAIL_PASS'];
$mail->setFrom('cuentas@appsalon.com');
$mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
$mail->Subject = 'Confirm your account';

//SET html
$mail ->isHTML(TRUE);
$mail->CharSet = 'UTF-8';
$contenido = "<html>";
$contenido .= "<p><strong>Hola " . $this->nombre . "</strong> You have created your account in App Salon, now just press the following link to confirm your account </p>";
$contenido .= "<p>Press here: <a href= '"    .  $_ENV['APP_URL']   .   "/confirmar-cuenta?token=" . $this->token . "'>Confirm account</a> </p>";
$contenido .= "<p> If you did not asked for this account ignore this message </p>";
$contenido .= "</html>";
$mail->Body = $contenido;

//enviar el email
$mail->send();

    }
    public function enviarInstrucciones(){
        $mail = new PHPMailerPHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'Reset your password';
        
        //SET html
        $mail ->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> You have asked to reset your password, follow the following link to do it. </p>";
        $contenido .= "<p>Press here: <a href= '"    .  $_ENV['APP_URL']   .   "/recuperar?token=" . $this->token . "'>Reset password</a> </p>";
        $contenido .= "<p> If you did not asked for this account ignore this message </p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;
        
        //enviar el email
        $mail->send();
    }
}
