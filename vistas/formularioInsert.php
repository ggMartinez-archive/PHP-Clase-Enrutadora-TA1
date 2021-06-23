

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>


    <?php if(isset($parametros['exito']) && $parametros['exito'] == true): ?>
        <div style="color: #00FF00"> La persona se guardo con exito </div>
    <?php endif; ?>

    <?php if(isset($parametros['exito']) && $parametros['exito'] == false): ?>
        <div style="color: #FF0000"> Hubo un problema al guardar la persona </div>
    <?php endif; ?>

    <form id="formulario" action="/insertar" method="post">
        Nombre: <input type="text" name="nombre" id="nombre"> <br>
        Apellido: <input type="text" name="apellido" id="apellido"> <br>
        Edad: <input type="number" name="edad" id="edad"> <br>
        Email: <input type="email" name="email" id="email"> <br>
        <input type="submit" value="Enviar">
    </form>

</body>
</html>