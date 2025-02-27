<?php
namespace Classes;

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
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '5addb5de89ea09';
        $mail->Password = 'ca8f383142969b';

        $mail->setFrom('cuentas@appsalon.com', 'AppSalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p> <strong> Hola " . $this->nombre ." </strong> Has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar_cuenta?token=". $this->token ."'>Confirmar Cuenta</a></p>";
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
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '5addb5de89ea09';
        $mail->Password = 'ca8f383142969b';

        $mail->setFrom('cuentas@appsalon.com', 'AppSalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Restablece tu contraseña';

        //Set HTML

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p> <strong> Hola " . $this->nombre ." </strong> Has solicitado restablecer tu contraseña, sigue el siguiente enlace </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=". $this->token ."'>Restablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
    }
}