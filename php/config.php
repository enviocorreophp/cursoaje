<?php
//Podemos usar las variables y constanes de la configuración del sitio
//teniendo en cuenta que tendremos o variables globales o constes globales
//aunque dentro de funciones usando define no tendremos problemas al importar
//este fichero fuera de la funcion

//Sitio de la pagina
define("SITE","http://localhost/"); 
$site = "http://localhost/";
//Datos de conexion de la BBDD
$bbdd = "mysql:host=localhost;dbname=login";
$dbuser = "userlogin";
$dbpass = "1234";

?>