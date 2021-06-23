<?php 
    require '../utils/autoloader.php';

    class PersonaModelo extends Modelo{
        public $id;
        public $nombre;
        public $apellido;
        public $edad;
        public $email;

        public function guardar(){
            $this -> id ? $this -> prepararUpdate() : $this -> prepararInsert();
            $this -> sentencia -> execute();

            if($this -> sentencia -> error){
                throw new Exception("Hubo un problema al cargar la persona: " . $this -> sentencia -> error);
            }
        }

        private function prepararUpdate(){
            $sql = "UPDATE persona set id = ?, nombre = ?, apellido = ?, edad = ?, email = ?";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_params("issis",
                $this -> id,
                $this -> nombre,
                $this -> apellido,
                $this -> edad,
                $this -> email 
            );
        }
        private function prepararInsert(){
            $sql = "INSERT INTO persona(nombre,apellido,edad,email) VALUES (?,?,?,?)";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_param("ssis",
                $this -> nombre,
                $this -> apellido,
                $this -> edad,
                $this -> email 
            );
        }
        public function eliminar(){
            $this -> prepararEliminar();
            $this -> sentencia -> execute();

            if($this -> sentencia -> error){
                throw new Exception("Hubo un problema al eliminar la persona: " . $this -> conexion -> error);
            }
        }

        private function prepararEliminar(){
            $sql = "DELETE FROM persona WHERE id = ?";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_param("i", $this -> id);
        }



        public function obtenerTodos(){
            $filas = $this -> crearArrayDePersonas();
            if($this -> conexion -> error){
                throw new Exception("Error al obtener las personas: " . $this -> conexion -> error);
            }
            return $filas;
        }

        private function crearArrayDePersonas(){
            $sql = "SELECT id,nombre,apellido,edad,email FROM persona";
            $filas = array();
            foreach($this -> conexion -> query($sql) -> fetch_all(MYSQLI_ASSOC) as $fila){
                $p = new PersonaModelo();
                $p -> id = $fila['id'];
                $p -> nombre = $fila['nombre'];
                $p -> apellido = $fila['apellido'];
                $p -> edad = $fila['edad'];
                $p -> email = $fila['email'];
                array_push($filas,$p);
            }
            return $filas;

        }

        public function obtenerUno($id){
            $this -> prepararObtenerUno($id);
            $resultado = $this -> sentencia -> execute() -> fetch_assoc();
            if($this -> sentencia -> error){
                throw new Exception("Error al obtener la personas: " . $this -> sentencia -> error);
            }
            asignarCamposDePersona($resultado);

        }
        private function prepararObtenerUno($id){
            $sql = "SELECT id,nombre,apellido,edad,email FROM persona WHERE id = ?";
            $this -> sentencia = $this -> conexion -> prepare($sql);
            $this -> sentencia -> bind_param("i", $id);
        }

        private function asignarCamposDePersona($resultado){
            $this -> id = $resultado['id'];
            $this -> nombre = $resultado['nombre'];
            $this -> apellido = $resultado['apellido'];
            $this -> edad = $resultado['edad'];
            $this -> email = $resultado['email'];
        }
    }