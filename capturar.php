<?php
require "conexion.php";

$name= $_POST["nom"];
$tel= $_POST["tel"];


$sql="insert into agenda(nombre,apellido) values ('$name','$tel')";

$obj = new controlDB();
$obj->actualizar($sql);


?>