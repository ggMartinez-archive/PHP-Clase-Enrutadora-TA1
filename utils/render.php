<?php 
    require '../utils/autoloader.php';
    
    function generarHtml($vista,$parametros){
        return require "../vistas/$vista.php";
    }

    function cargarVista($vista){
        generarHtml($vista,null);
    }