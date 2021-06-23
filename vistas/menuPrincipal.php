<?php 
    session_start();
?>

MENU PRINCIPAL <br>

<?php 
    echo "ID: " . $_SESSION['usuarioId'] . "<br>";
    echo "Nombre de usuario: " . $_SESSION['usuarioNombre'] . "<br>";
    echo "Tipo de usuario: " . $_SESSION['usuarioTipo'] . "<br>";
    echo "Nombre completo: " . $_SESSION['usuarioNombreCompleto'];
