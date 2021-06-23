<?php 
    foreach($parametros['personas'] as $fila){   
        echo $fila['id'] . " " . $fila['nombre'] . " " . $fila['apellido'] . " " . $fila['edad'] . " " . $fila['email'] . "<br>";
    }
    