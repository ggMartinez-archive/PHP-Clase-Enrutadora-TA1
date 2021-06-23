
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/estilo.css">
    <title>Document</title>

</head>
<body>



    <?php if(isset($parametros['falla']) && $parametros['falla'] == true): ?>
        <div style="color: #FF0000"> Login Incorrecto</div>
    <?php endif; ?>

    <form action="/login" method="post">
        Nombre: <input type="text" name="nombre"> <br>
        Password: <input type="password" name="password"> <br>
        <input type="submit" value="Enviar">
    </form>

</body>
</html>