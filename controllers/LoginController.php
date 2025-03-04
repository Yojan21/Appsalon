<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController{
    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $usuario = new Usuario;
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                //Comprobar si existe el usuario
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario){
                    //Verificar el Password  
                                
                    if($usuario->comprobarPassword($auth->password)){
                        //Autenticar el usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        //Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                        
                    } else {
                        Usuario::setAlerta('error', 'Password incorrecto');
                    }
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }

        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        header('location: /');
    }

    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar el Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu Email');

                }else{
                    Usuario::setAlerta('error', 'el usuario no existe o no esta confirmado');
                }
            }

        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide_password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar_password', [
            'alertas' => $alertas,
            'error'=> $error
        ]);
    }

    public static function crear(Router $router){

        $usuario = new Usuario;

        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alertas este vacio
            if(empty($alertas)){
                //Verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                
                if($resultado-> num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    
                    //Hashear el Password
                    $usuario->hashPassword();
                    
                    //Generar un token unico
                    $usuario->crearToken();
                    //Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email,$usuario->token);
                    
                    $email->enviarConfirmacion();
                    
                    //Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear_cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje', [

        ]);
    }

    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)){
            //Mostrar Error
            Usuario::setAlerta('error', 'Token no Valido');
        }else{
            //Modificar a confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar_cuenta', [
            'alertas' => $alertas
        ]);
    }
}