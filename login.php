<?php 

require 'conexion.php';
require 'funcs.php';

session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['password']; 

$sentencia = $mysqli->prepare("SELECT fecha_cambio_contrasena from siec_usuarios where usu_username= ?");
$sentencia->bind_param("s",$usuario);
$sentencia->execute();
$result =$sentencia->get_result();
while ($row = $result->fetch_assoc()) {
	$fechacontra= $row['fecha_cambio_contrasena'];
}
$sentencia->free_result();
$sentencia->close();




$sentencia = $mysqli->prepare("SELECT DATEDIFF(curdate(), (select fecha_cambio_contrasena from siec_usuarios where usu_username =?)) as dias");
$sentencia->bind_param("s",$usuario);
$sentencia->execute();
$result =$sentencia->get_result();
while ($row = $result->fetch_assoc()) {
	$dias= $row['dias'];
}
$sentencia->free_result();
$sentencia->close();






$sentencia = $mysqli->prepare("SELECT par_numero FROM siec_parametros where par_id_parametros=2");
$sentencia->execute();
$result  = $sentencia->get_result();
 while ($row = $result->fetch_assoc()) {
    $dias_vence = $row['par_numero'];
	
}
$sentencia->free_result();
$sentencia->close();




$sentencia = $mysqli->prepare("SELECT par_numero FROM siec_parametros where par_id_parametros=1");
$sentencia->execute();
$result  = $sentencia->get_result();
 while ($row = $result->fetch_assoc()) {
    $intentostotal = $row['par_numero'];
}
$sentencia->free_result();
$sentencia->close();

$sentencia = $mysqli->prepare("SELECT usu_username from siec_usuarios where usu_username = ?");
$sentencia->bind_param("s", $usuario);
$sentencia->execute();
$sentencia->store_result();
$row_cnt = $sentencia->num_rows;


$sentencia->free_result();
$sentencia->close();





if($row_cnt>0){
	$sentencia = $mysqli->prepare("SELECT usu_id_usuario, usu_username, usu_pass, usu_nombre_com, usu_id_rol, user_fecha_creacion, usu_intentos, usu_id_clinica, fecha_cambio_contrasena, estado_usuario ,activacion,usu_peticion_pass from siec_usuarios where usu_username = ? ");
	$sentencia->bind_param("s", $usuario);
	$sentencia->execute();


	$result  = $sentencia->get_result();
	
	while ($row = $result->fetch_assoc()) {
		$iduser = $row['usu_id_usuario'];
		$idrol = $row['usu_id_rol'];
		$user = $row['usu_username'];
        $intentos = $row['usu_intentos'];
        $passwd = $row['usu_pass'];
        $clinica=$row['usu_id_clinica'];
        $name=$row['usu_nombre_com'];
        $estado_usuario = $row['estado_usuario'];
        $activacion = $row['activacion'];
        $peticion= $row['usu_peticion_pass'];
    }

	$sentencia->free_result();
	$sentencia->close();
	
	
	
	
	
	
	
	if ($iduser==1){
		
			$validaPassw = password_verify($clave, $passwd);
		
			if($validaPassw){
				

				$_SESSION['id_usuario']= $iduser;
				$_SESSION['clinica']= $clinica;
				$_SESSION['id_rol'] = $idrol;
				$_SESSION['usuario'] = $user;
				$_SESSION['nombre_usuario'] = $name;

				

					echo json_encode("ok");
			}
			else{
				
				echo json_encode("Datos Incorrectos " );
			}
		
		
		
		}elseif($activacion==1){
		
	




	if($intentos<$intentostotal){

			$validaPassw = password_verify($clave, $passwd);
		
			if($validaPassw){
				$sentencia = $mysqli->prepare("UPDATE siec_usuarios set usu_intentos = 0 where usu_id_usuario = ?");
				$intentos+=1;
				$sentencia->bind_param("i", $iduser);
				$sentencia->execute();
				$sentencia->free_result();
				$sentencia->close();

				$_SESSION['id_usuario']= $iduser;
				$_SESSION['user_login_status']=1;
				$_SESSION['id_rol'] = $idrol;
				$_SESSION['usuario'] = $user;
                $_SESSION['clinica']= $clinica;
				$_SESSION['nombre_usuario'] = $name;

				

				if((strtolower($estado_usuario)== strtolower('nuevo'))or ($dias>=$dias_vence) or ($peticion=="1") ){
					
					echo json_encode("nuevo");
				}
				else
					echo json_encode("ok");
			}
			else{
				$sentencia = $mysqli->prepare("UPDATE siec_usuarios set usu_intentos = ? where usu_id_usuario = ?");
				$intentos+=1;
				$sentencia->bind_param("ii", $intentos,$iduser);
				$sentencia->execute();
				$sentencia->free_result();
				$sentencia->close();
				echo json_encode("Datos Incorrectos , le quedan  ". ( $intentostotal-($intentos)." intentos." ));
			}
	 }else{
		echo json_encode("Ha Excedido el Limite de Intentos ");
		
		$sentencia = $mysqli->prepare("UPDATE siec_usuarios set activacion = 0, usu_intentos=0 where usu_id_usuario = ?");
				$sentencia->bind_param("i",$iduser);
				$sentencia->execute();
				$sentencia->free_result();
				$sentencia->close();
		        $estado="INACTIVO";
		
		$sentencia = $mysqli->prepare("UPDATE siec_usuarios set estado_usuario = ? where usu_id_usuario = ?");
				$sentencia->bind_param("si",$estado,$iduser);
				$sentencia->execute();
				$sentencia->free_result();
				$sentencia->close();
		
		
	}
	
	

	
	
}else{
	echo json_encode("BLOQUEADO O INACTIVO");
}
	
		
	
}else{
	echo json_encode("Usuario o  Correo Electronico no Registrados");
}




?>

