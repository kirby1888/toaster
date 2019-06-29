
<?php


require '../funcs/conexion.php';
require '../funcs/funcs.php';
session_start();
if(!isset($_SESSION['id_usuario'])){
    header ("Location: index.php");
}



$clinica= $_SESSION['clinica'];
$user_id = $_SESSION['id_usuario'];
	$rol=$_SESSION['id_rol'];


?>
       <link href="css1/bootstrap.min.css" rel="stylesheet">
    <link href="css1/datepicker3.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css1/estilos.css" rel="stylesheet">

        
  
     
      
        <div class="dataTables_length" id="tableListar_length">
      <table class="table" id="tableListar">
        <thead>
          <tr class="info">
  
             <th>Id</th>
             <th>Clave</th>
             <th>Nombre </th>
             <th>Diagnostíco</th>
              <th>Doctor</th>
             <th>Fecha atencion</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
			
			
			//select *from siec_atenciones where ate_diagnostico not in (''); EXCEPCIONES EN SQL

  	 if ($rol !=1){
         $clinica_b="and ate_id_clinica=$clinica ";
         
     }else{
    $clinica_b="";
                 
                 
                 
     }

			
			 $sql = "SELECT * FROM siec_atenciones inner join siec_empleados on siec_atenciones.ate_id_empleado= siec_empleados.emp_id_empleado inner join siec_usuarios on siec_atenciones.ate_id_usuario= siec_usuarios.usu_id_usuario  where status=2 $clinica_b order by ate_id_atencion ASC";  
             

			$query = mysqli_query($mysqli, $sql);
     
			
			$count_query   = mysqli_query($mysqli, "SELECT count(*) AS numrows FROM siec_atenciones  ");
		$row1= mysqli_fetch_array($count_query);
			
			$numrows = $row1['numrows'];
			
 
          if ($numrows>0){
			
        while ($row=mysqli_fetch_array($query)){
			
$id=$row['ate_id_atencion'];
            $id_emple= $row['ate_id_empleado'];
			               $clave=$row['emp_clave_empleado'];
						$nombre=$row['emp_nombre'];
						$diagnostico=$row['ate_diagnostico'];
            $doctor=$row['usu_username'];
            $padece=$row['ate_padece'];
				        $fecha=$row['ate_fecha_visita'];
			            
                 $fecha= date('d/m/Y', strtotime($fecha));
          ?>
   
             
              <tr>
              
            <td><?php echo $id ?></td>
                <td><?php echo $clave;?></td>
                <td><?php echo $nombre;?></td>
                 <td><?php echo $padece; ?></td>
                  <td><?php echo $doctor;?></td>
                  <td><?php echo $fecha;?></td>
                <td>
                    
                
                   
             
       
             
            <a href="#" class='btn btn-default' title='Ver historial'  data-toggle="modal" data-target="#myModal" onclick='cargar(1)' ><i class="fa fa-eye"></i></a> 
			<input value ="<?php echo $id_emple;  ?>" type="hidden" id="id_emple" >	
              <a href="reporte/re_aten.php?id=<?php echo $id_emple;?>"   data-toggle="tooltip" class='btn btn-danger' title='imprimir' ><i class="fa fa-print"></i></a>  
               
             
               
               
                </td>
              </tr>
          <?php
            
           }
          }else{ 
          
          ?>
          <tr>
            <td colspan="4">No se encontraron resultados</td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
     <script>
                    function cargar(page){
			var q= $("#q").val();
            			var emple= $("#id_emple").val();
			$("#loader2").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_consultashis.php?emple='+emple+'&action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader2').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div2").html(data).fadeIn('slow');
					$('#loader2').html('');
					
				}
			})
		}
    </script>
    
    
    
            
            
            
            
            
            
            
            
            
            
            
            
            
      </div>
      <script src="js1/jquery-1.11.1.min.js"></script>
    <script src="js1/bootstrap.min.js"></script>
	<script src="js1/bootstrap-datepicker.js"></script>
	<script src="js1/locales/bootstrap-datepicker.es.js"></script>
	<script src="js1/jquery.dataTables.min.js"></script>
    
        <script src="js1/dataTables.bootstrap.js"></script>

        <script src="js1/validator.js"></script>

    <script src="js1/global.js"></script>
     