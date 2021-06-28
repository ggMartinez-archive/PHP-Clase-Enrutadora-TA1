<?php 

    require '../utils/autoloader.php';

    class PersonaController{

        public static function AltaDePersona($request){

            if($nombre !== "" && $apellido !== "" && $edad !== "" && $email !== ""){
                try{
                    $p = new PersonaModelo();
                    $p -> nombre = $request['post']['nombre'];
                    $p -> apellido = $request['post']['apellido']; 
                    $p -> edad = $request['post']['edad'];
                    $p -> email = $request['post']['email'];
                    $p -> guardar();
                    return generarHtml('formularioInsert',['exito' => true]);
                }
                catch(Exception $e){
                    error_log($e -> getMessage());
                    return generarHtml('formularioInsert',['exito' =>false]);
                }
            }
            return generarHtml('formularioInsert',['exito' => false]);
        }

        public static function ObtenerPersonas(){
            
            if(!isset($_SESSION['autenticado'])){
                header("Location: /login");
                return;
            }
            
            $p = new PersonaModelo();
            $personas = array();
            foreach($p -> obtenerTodos() as $fila){
                $persona = array(
                    "id" => $fila -> id,
                    "nombre" => $fila -> nombre,
                    "apellido" => $fila -> apellido,
                    "edad" => $fila -> edad,
                    "email" => $fila -> email
                );
                array_push($personas,$persona);
            }
            return generarHtml('listar',['personas' => $personas]);
        }
        
        public static function EliminarPersona($request){
            $p = new PersonaModelo();
            $p -> obtenerUno($request['post']['id']);
            $p -> eliminar();
        }

    }
    
