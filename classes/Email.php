<?php
namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token)    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Crear el Objeto de Email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->setFrom('cuentas@appsalon.com', 'AppSalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';
        //Set HTML

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p> <strong> Hola " . $this->nombre ." </strong> Has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace </p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL']. "/confirmar_cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
    }

    public function enviarInstrucciones(){
        //Crear el Objeto de Email

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com', 'AppSalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Restablece tu contraseña';

        //Set HTML

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p> <strong> Hola " . $this->nombre ." </strong> Has solicitado restablecer tu contraseña, sigue el siguiente enlace </p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL']. "/recuperar?token=". $this->token ."'>Restablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
    }
}