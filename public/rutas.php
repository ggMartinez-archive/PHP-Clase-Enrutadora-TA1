<?php  
    require '../utils/autoloader.php';
    require '../routes/routes.class.php';

    Routes::Add("/","get","PersonaController::ObtenerPersonas");
    Routes::Add("/login","get","UsuarioController::MostrarLogin");
    Routes::Add("/login","post","UsuarioController::IniciarSesion");
    Routes::Add("/principal","get","UsuarioController::MostrarMenuPrincipal");
    Routes::AddView("/publico","publico");


    Routes::Run();

    