<?php 

    require '../utils/autoloader.php';

    class UsuarioController{
        public static function IniciarSesion($request){
            try{
                $u = new UsuarioModelo();
                $u -> nombre = $request['post']['nombre'];
                $u -> password = $request['post']['password'];
                $u -> Autenticar();
                self::crearSesion($u);                
                header("Location: /principal");
            }
            catch (Exception $e) {
                error_log("Fallo login del usuario " . $usuario);
                generarHtml("formularioLogin",["falla" => true]);
            }

        }

        public static function MostrarLogin($request){
            session_start();
            if(isset($_SESSION['autenticado'])) header("Location: /principal");
            else return cargarVista("formularioLogin");
        }

        public static function MostrarMenuPrincipal($request){
            return cargarVista("menuPrincipal");
        }


        private static function crearSesion($usuario){
            session_start();
            $_SESSION['usuarioId'] = $usuario -> id;
            $_SESSION['usuarioNombre'] = $usuario -> nombre;
            $_SESSION['usuarioTipo'] = $usuario -> tipo;
            $_SESSION['usuarioNombreCompleto'] = $usuario -> nombreCompleto;
            $_SESSION['autenticado'] = true;

        }

        public static function AltaDeUsuario($request){
            try{
                $u = new UsuarioModelo();
                $u -> nombre = $request['post']['nombre'];
                $u -> password = $request['post']['password']; 
                $u -> tipo = $request['post']['tipo'];
                $u -> nombreCompleto = $request['post']['$nombreCompleto'];
                $u -> Guardar();
                return generarHtml('formularioInsertUsuario',['exito' => true]);
            }
            catch(Exception $e){
                error_log($e -> getMessage());
                return generarHtml('formularioInsertUsuario',['exito' =>false]);
            }
        }
    }