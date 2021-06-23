# PHP y MySQL con Docker - Para el pueblo!

Instalar docker, docker-compose, clonar este repo, y tirar esto en la consola:
`docker-compose up --build`


CREAR ESTA TABLA:
```
create table persona(
    id int primary key auto_increment,
    nombre varchar(10),
    apellido varchar(10),
    edad int,
    email varchar(50)
);

create table usuario(
    id int primary key auto_increment,
    nombre varchar(20),
    password varchar(255),
    tipo char,
    nombre_completo varchar(100)
);
```