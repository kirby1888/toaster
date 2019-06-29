<?php



	$mysqli=new mysqli("127.0.0.1","root","","bd_siec"); 
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}

	
?>