<?php 
    require '../utils/autoloader.php';

    class Routes {
        private static $routes = Array();
        private static $notFound;

        public static function Add($url,$metodo,$funcion,$middleware = null){
            array_push(self::$routes,[
                'url' => $url,
                'funcion' => $funcion,
                'metodo' => $metodo,
                'vista' => null,
                'tipo' => "controlador",
                'middleware' => $middleware
            ]);
        }

        public static function AddView($url,$vista,$middleware = null){
            array_push(self::$routes,[
                'url' => $url,
                'funcion' => null,
                'metodo' => "get",
                'tipo' => "vista",
                'vista' => $vista,
                'middleware' => $middleware
            ]);
        }


        public static function Run(){
            $urlNavegador = $_SERVER['REQUEST_URI'];
            $metodoNavegador = strtolower($_SERVER['REQUEST_METHOD']);
            
            self::$notFound = true;
            $tipo = null;
            $vista = null;
            $middleware = null;
            foreach(self::$routes as $route){
                if($route['tipo'] == "controlador"){
                    if($urlNavegador === $route['url'] && $metodoNavegador === $route['metodo']){
                        $funcion = $route['funcion'];
                        $tipo = $route['tipo'];
                        self::$notFound = false;
                        $middleware = $route['middleware'];
                        break;
                    }
                }
                else {
                    if($urlNavegador === $route['url']){
                        $tipo = $route['tipo'];
                        $vista = $route['vista'];
                        self::$notFound = false;
                        $middleware = $route['middleware'];
                        break;
                    }
                }
            }

            if(self::$notFound) cargarVista("404");
            if($tipo === "vista") 
                if($middleware)
                    self::ejecutarMiddlewareView($middleware,$vista);
                else 
                    cargarVista($vista);
            if($tipo === "controlador") {
                if($middleware)
                    self::ejecutarMiddleware($middleware,$funcion);
                else 
                    self::ejecutarControlador($funcion);
            }
            
        }

        private function ejecutarControlador($funcion){
            $contexto = [
                'post' => $_POST,
                'get' => $_GET,
                'server' => $_SERVER,
                'file' => $_FILE
            ];
            call_user_func_array($funcion,$contexto);
        }

        private function ejecutarMiddleware($middleware,$funcion){
            $contexto = [
                'post' => $_POST,
                'get' => $_GET,
                'server' => $_SERVER,
                'funcion' => $funcion,
                'file' => $_FILE

            ];
            call_user_func_array($middleware,$contexto);

        }


        private function ejecutarMiddlewareView($middleware,$vista){
            $contexto = [
                'post' => $_POST,
                'get' => $_GET,
                'server' => $_SERVER,
                'vista' => $vista
            ];
            call_user_func_array($middleware,$contexto);

        }
    }
