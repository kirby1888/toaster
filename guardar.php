<?php 

require 'conexion.php';

$nom=$_POST['nom'];
$ape=$_POST['ape'];
   
    
	
                
  if(issset($nom)){
    
    
     $sentencia = $mysqli->prepare(" INSERT INTO agenda(nombre,apellido) VALUES (?,?)");
	$sentencia->bind_param("ss", $nom,$ape);
    	
	
$istrue = $sentencia->execute();
	$sentencia->free_result();
	$sentencia->close();
    
 
         echo json_encode("ok");
    
    
    
    
        } else{
    
    
    
    
    echo json_encode( "maximo son 3 dias por diagnostico le quedan ".$dias_dis." por este diagnostico");
    
}
				
             
			
			
    



?>
  
	