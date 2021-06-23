<?php  
    require '../utils/autoloader.php';
    require '../routes/routes.class.php';

    Routes::Add("/","PersonaController::ObtenerPersonas");
    Routes::Add("/login","UsuarioController::MostrarLogin");
    Routes::Add("/login","UsuarioController::IniciarSesion","post");

    Routes::Run();

    