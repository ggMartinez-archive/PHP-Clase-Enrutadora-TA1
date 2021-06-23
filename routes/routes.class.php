<?php 
    require '../utils/autoloader.php';

    class Routes {
        private static $routes = Array();
        private static $notFound;

        public static function Add($url,$funcion,$metodo = "get"){
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
                    // Ejecutar funcion
                    echo "Yupiiiiiii";
                    self::$notFound = false;
                    break;
                }
            }

            if(self::$notFound){
                cargarVista("404");
            }




        }
    }
