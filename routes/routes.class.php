<?php 
    require '../utils/autoloader.php';

    class Routes {
        private static $routes = Array();
        private static $notFound;

        public static function Add($url,$metodo,$funcion){
            array_push(self::$routes,[
                'url' => $url,
                'funcion' => $funcion,
                'metodo' => $metodo,
                'tipo' => "controlador"
            ]);
        }

        public static function AddView($url,$vista){
            array_push(self::$routes,[
                'url' => $url,
                'funcion' => null,
                'metodo' => "get",
                'tipo' => "vista"
            ]);
        }


        public static function Run(){
            $urlNavegador = $_SERVER['REQUEST_URI'];
            $metodoNavegador = strtolower($_SERVER['REQUEST_METHOD']);
            
            self::$notFound = true;
            $tipo = null;
            $vista = null;
            foreach(self::$routes as $route){
                if($route['tipo'] == "controlador"){
                    if($urlNavegador === $route['url'] && $metodoNavegador === $route['metodo']){
                        $funcion = $route['funcion'];
                        $tipo = $route['tipo'];
                        self::$notFound = false;
                        break;
                    }
                }
                else {
                    if($urlNavegador === $route['url']){
                        $tipo = $route['tipo'];
                        $vista = $route['url'];
                        self::$notFound = false;
                        break;
                    }
                }
            }

            if(self::$notFound) cargarVista("404");
            if($tipo === "vista") cargarVista($vista);
            if($tipo === "controlador") self::ejecutarControlador($funcion);
            
        }

        private function ejecutarControlador($funcion){
            $contexto = [
                'post' => $_POST,
                'get' => $_GET,
                'server' => $_SERVER
            ];
            call_user_func_array($funcion,$contexto);
        }
    }
