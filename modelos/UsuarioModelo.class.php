<?php 
    require '../utils/autoloader.php';

    class UsuarioModelo extends Modelo{
        public $id;
        public $nombre;
        public $password;
        public $tipo;
        public $nombreCompleto;

        public function Guardar(){

            $this -> id ? $this -> prepararUpdate() : $this -> prepararInsert();
            $this -> sentencia -> execute();

            if($this -> sentencia -> error){
                throw new Exception("Hubo un problema al cargar el usuario: " . $this -> sentencia -> error);
            }
        }

        private function prepararUpdate(){
            $this -> password = $this -> hashearPassword($this -> password);
            $sql = "UPDATE usuario set id = ?, nombre = ?, password = ?, tipo = ?, nombre_completo = ?";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_params("issis",
                $this -> id,
                $this -> nombre,
                $this -> password,
                $this -> tipo,
                $this -> nombreCompleto 
            );
        }
        private function prepararInsert(){
            $this -> password = $this -> hashearPassword($this -> password);
            $sql = "INSERT INTO usuario(nombre,password,tipo,nombre_comlpeto) VALUES (?,?,?,?)";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_param("ssss",
                $this -> nombre,
                $this -> password,
                $this -> tipo,
                $this -> nombreCompleto 
            );
        }

        public function Autenticar(){
            $this -> prepararAutenticacion();
            $this -> sentencia -> execute();

            $resultado = $this -> sentencia -> get_result() -> fetch_assoc();

            if($this -> sentencia -> error){
                throw new Exception("Error al obtener el usuario: " . $this -> sentencia -> error);
            }


            if($resultado){
                $comparacion = $this -> compararPasswords($resultado['password']);
                if($comparacion){
                   $this -> asignarDatosDeUsuario($resultado);
                }   
                else{
                    throw new Exception("Error al iniciar sesion");
                }
            }
            
            else throw new Exception("Error al iniciar sesion");
        }

        private function compararPasswords($passwordHasheado){
            return password_verify($this -> password, $passwordHasheado);
        }


        private function prepararAutenticacion(){
            $sql = "SELECT id,nombre,password,tipo,nombre_completo FROM usuario WHERE nombre = ? ";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_param("s", $this -> nombre);
        }

        private function asignarDatosDeUsuario($resultado){
            $this -> id = $resultado['id'];
            $this -> nombre = $resultado['nombre'];
            $this -> tipo = $resultado['tipo'];
            $this -> nombreCompleto = $resultado['nombre_completo'];
        }
        
        private function hashearPassword($password){
            return password_hash($password,PASSWORD_DEFAULT);
        }
    }

