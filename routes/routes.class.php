<?php 
    require '../utils/autoloader.php';

    class Routes {
        private static $routes = Array();
        private static $notFound;

        public static function Add($url,$metodo,$funcion){
            array_push(self::$routes,[
                'url' => $url,
                'funcion' => $funcion,
                'metodo' => $metodo
            ]);
        }

        public static function Run(){
            $urlNavegador = $_SERVER['REQUEST_URI'];
            $metodoNavegador = strtolower($_SERVER['REQUEST_METHOD']);
            
            self::$notFound = true;

            foreach(self::$routes as $route){
                if($urlNavegador === $route['url'] && $metodoNavegador === $route['metodo']){
                    $funcion = $route['funcion'];
                    self::$notFound = false;
                    break;
                }
            }

            if(self::$notFound) cargarVista("404");
            else ejecutarControlador($funcion);
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
