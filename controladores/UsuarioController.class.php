<?php 

    require '../utils/autoloader.php';

    class UsuarioController{
        public static function IniciarSesion($usuario,$password){
            try{
                $u = new UsuarioModelo();
                $u -> nombre = $usuario;
                $u -> password = $password;
                $u -> Autenticar();
                self::crearSesion($u);
                //cargarVista("menuPrincipal");
                
                header("Location: /principal");
            }
            catch (Exception $e) {
                error_log("Fallo login del usuario " . $usuario);
                generarHtml("formularioLogin",["falla" => true]);
            }

        }

        public static function MostrarLogin(){
            session_start();
            if(isset($_SESSION['autenticado'])) header("Location: /principal");
            else return cargarVista("formularioLogin");
        }

        public static function MostrarMenuPrincipal(){
            session_start();
            if(!isset($_SESSION['autenticado'])) header("Location: /login");
            else return cargarVista("menuPrincipal");
        }


        private static function crearSesion($usuario){
            session_start();
            ob_start();
            $_SESSION['usuarioId'] = $usuario -> id;
            $_SESSION['usuarioNombre'] = $usuario -> nombre;
            $_SESSION['usuarioTipo'] = $usuario -> tipo;
            $_SESSION['usuarioNombreCompleto'] = $usuario -> nombreCompleto;
            $_SESSION['autenticado'] = true;

        }

        public static function AltaDeUsuario($usuario,$password,$tipo,$nombreCompleto){

            if($usuario !== "" && $password !== "" && $tipo !== "" && $nombreCompleto !== ""){
                try{
                    $u = new UsuarioModelo();
                    $u -> nombre = $nombre;
                    $u -> password = $password; 
                    $u -> tipo = $tipo;
                    $u -> nombreCompleto = $nombreCompleto;
                    $u -> Guardar();
                    return generarHtml('formularioInsertUsuario',['exito' => true]);
                }
                catch(Exception $e){
                    error_log($e -> getMessage());
                    return generarHtml('formularioInsertUsuario',['exito' =>false]);
                }
            }
            return generarHtml('formularioInsertUsuario',['exito' => false]);
        }

    }