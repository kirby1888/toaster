<?php 
require  'conexion.php';

?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <title>Untitled Document</title>
	<meta name="Author" content=""/>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2>insertar registros </h2>

<form action="capturar.php" method="post">
<table style="width:100%">
  <tr>
    <th>Name</th>
    <th>Telephone</th>
  </tr>
  <tr>
    <td><input type="text" name="nom"></td>
    <td><input type="text" name="tel"></td>

  </tr>
</table>

<input type="submit">
</form> 

</body>
</html>
