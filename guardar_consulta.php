<?php 

require 'conexion.php';
require 'funcs.php';

session_start();
$tipo=$_POST['incapacidad'];
$dias=$_POST['dias'];
$padece=$_POST['padece'];
$id_emple=$_POST['id_emple'];
//

$moti=$_POST['motivo'];
$diagnostico=$_POST['diagnostico'];
$fecha_inicio=$_POST['fecha_inicio'];
$fecha_fin=$_POST['fecha_fin'];
$clave=$_POST['clave'];
$id_usuario= $_SESSION['id_usuario'];
$fc=$_POST['fc'];
$fr=$_POST['fr'];
$presion=$_POST['pa'];
$tempe=$_POST['temp'];
$peso=$_POST['peso'];
$imc=$_POST['imc'];
$glu=$_POST['glu'];
$id_atencion=$_POST['id_atencion']; 




if (!empty($_POST['diagnostico'])){
   
    
   
			if($tipo==1){
		if (!empty($_POST['dias'])	&& !empty($_POST['padece'])&& !empty($_POST['motivo'])){
		$cant_dia=getDIAS($padece,$id_emple);
    $dias_dis= 3-$cant_dia;
    
    
    $can_dia=$cant_dia+$dias;
                
  if(($can_dia <= 3) && ($can_dia >0)){
    
    

    
         
    // insert atenciones
    
  $sentencia = $mysqli->prepare("UPDATE siec_atenciones set ate_diagnostico =?,  ate_f_cardiaca =?, ate_f_respiratoria =?, ate_presion =?, ate_temperatura =?, ate_peso_lbs =?, ate_imc =?, ate_glucometria =? ,ate_padece=?, status = '2'  where ate_id_atencion = ?");
	
	$sentencia->bind_param("siiiiiiisi",$diagnostico, $fc, $fr,$presion,$tempe,$peso,$imc,$glu,$padece,$id_atencion);
	$isOk= $sentencia->execute();
	$sentencia->free_result();
	$sentencia->close();
    
    

    //de las incapacidades
     $sentencia = $mysqli->prepare(" INSERT INTO siec_incapacidades(inc_id_atencion, inc_id_empleado, inc_id_usuario, inc_id_motivo, inc_tid_incapacidad, inc_diagnostico, inc_fecha_inicio, inc_fecha_fin, inc_dias_incapacidad) VALUES (?,?,?,?,?,?,?,?,?)");
	$sentencia->bind_param("iiiiissss", $id_atencion ,$id_emple,$id_usuario,$moti,$tipo,$padece,$fecha_inicio,$fecha_fin,$dias);
    	
	
$istrue = $sentencia->execute();
	$sentencia->free_result();
	$sentencia->close();
    
 
         echo json_encode("ok");
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
        } else{
    
    
    
    
    echo json_encode( "maximo son 3 dias por diagnostico le quedan ".$dias_dis." por este diagnostico");
    
}
				
   } else{
    
    
    
    
    echo json_encode( "complete los campos para poder asignarle la incapacidad");
    
}
               
			}
			else{
				
                
                //si no se tiene incapacidad
                $enfermedades= enfermedad($padece);
                
                 $sentencia = $mysqli->prepare("UPDATE siec_atenciones set ate_diagnostico =?,  ate_f_cardiaca =?, ate_f_respiratoria =?, ate_presion =?, ate_temperatura =?, ate_peso_lbs =?, ate_imc =?, ate_glucometria =? ,ate_padece=?, status = '2'  where ate_id_atencion = ?");
	
	$sentencia->bind_param("siiiiiiisi",$diagnostico, $fc, $fr,$presion,$tempe,$peso,$imc,$glu,$padece,$id_atencion);
	$isOk= $sentencia->execute();
	$sentencia->free_result();
	$sentencia->close();
    
         echo json_encode("ok");
                
				
			}
    
}else{
echo json_encode("diagnostico vacio");
}


?>
  
	
	