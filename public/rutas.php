<?php  
    require '../utils/autoloader.php';
    require '../routes/routes.class.php';

    Routes::Add("/login","get","UsuarioController::MostrarLogin");
    Routes::Add("/login","post","UsuarioController::IniciarSesion");
    Routes::AddView("/","publico");

    Routes::Run();

    