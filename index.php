<?php

require 'conexion.php';
//require 'funcs/funcs.php';
 
$errors = array();
if(isset ($_SESSION['id_usuario'])) 
   {
    header("location: home.php");
	exit;
}
else{
?>
<!DOCTYPE HTML>
<html>
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIEC ENEE: Login</title>

<link rel="stylesheet" href="style.css" type="text/css"  />
    <link href="bootstrap.min.css" rel="stylesheet" media="screen">

<link rel="stylesheet" href="css/stylelogin.css" type="text/css"  />
    	<link rel="stylesheet" href="toastr.min.css" >
	
</head>
<body>
<h1>SIEC-ENEE </h1>
<!--<div class="signin-form">-->

	<div class="w3ls-login">
     
        
       <form class="" method="post" id="loginform">
      
   <div>&nbsp;&nbsp;&nbsp;&nbsp;</div>
      
     
        <div class="agile-field-txt">
            <label>
					<i class="glyphicon glyphicon-user" aria-hidden="true"></i> Usuario :</label>
        <input type="text" class="form-control" name="usuario" onPaste="return false" placeholder="usuario" maxlength="15" required />
        <span id="check-e"></span>
        </div>
        
        <div class="agile-field-txt">
            <label>
					<i class="glyphicon glyphicon-lock" aria-hidden="true"></i> password :</label>
        <input type="password" class="form-control" name="password" placeholder="Password" id="password" maxlength="15" required />
            
            
            
            
            <div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Show password</label>
				</div>
        </div>
       <script>
				function myFunction() {
					var x = document.getElementById("password");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				}
           
           
           
           
           function myFunction2() {
					var x = document.getElementById("pass");
                    var y =document.getElementById("repass");
					if (x.type === "password") {
						x.type = "text";
                        y.type="text";
					} else {
						x.type = "password";
                        y.type = "password";
					}
				}
           
           
           
           
           
           
           
			</script>
     	<hr />
        
        <div class="w3ls-login  w3l-sub">
            <input type="submit" name="btn-login" class="btn btn-default">
              
        </div>  
      	<br />
           <!--- <label>Don't have account yet ! <a href="sign-up.php">Sign Up</a></label>-->
      </form>

    </div>
    
<div id="modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title">BIENVENIDO A SIEC</h4>
      </div>
      <div class="modal-body" >
    		<div class="panel panel-info">
    			<div class="panel-heading">
    				Actualiza tu Password
    			</div>
    			<div class="panel-body">
    				<form id="formpreguntas" class="form form-horizontal" >
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input class="form-control" type="password" name="pass" id="pass" value=""  maxlength="15"placeholder="" required>
                               
                            </div>
                        </div>
						 <div class="form-group">
                            <label for="password"  maxlegnt="15 "class="col-md-4 control-label">Repita su Password</label>

                            <div class="col-md-6">
                                <input class="form-control" type="password" name="repass" id="repass" maxlength="15" value="" placeholder="" required>
                            </div>
                       
                             
                        </div>
                        	 <div class="form-group">
                            

                            <div class="col-md-6">
                              <input id="check2" name="check2" type="checkbox" value="show password" onclick="myFunction2()">
                                <label class="check" for="check2">Show password</label>
                            </div>
                       
                             
                        </div>
                        <center>
                             
						<input type="submit" class="btn btn-danger" name="guardar" value="Guardar" />
   				   				
						</center>
    				</form>
    			</div>
    		</div>
      </div>
    </div>
  </div>
</div>
    
    
    
    
    
    
    
    
    
    <script src="jquery.min.js" ></script>
<script src="bootstrap.min.js" ></script>
<script src="toastr.min.js" ></script>
<!--</div>-->

</body>
</html>
<script>
$(document).on('ready', function() {
$(document).on('submit', '#loginform', function(event) {
		event.preventDefault();
		$.ajax({
			url: 'login.php',
			type: 'POST',
			dataType: 'JSON',
			data: $(this).serialize(),
			success:function(data){
	
				toastr.options.timeOut = 2000;
				 toastr.options.showMethod = 'fadeIn';
				 toastr.options.hideMethod = 'fadeOut';
				 toastr.options.positionClass = 'toast-top-center';
				
				if(data=="ok"){
					toastr.success("Bienvenido a SIEC");
					setTimeout(function(){
						location.href="home.php";
					},2000);
				}
				else if(data=="nuevo"){
					toastr.success("Usuario, Deberá actualizar su contraseña");
					setTimeout(function(){
					
						$('#modal').modal({
						  backdrop: 'static',
						  keyboard: false
						});

					},2000);
				}
				else{
					toastr.error(data);
				}
			}
		})
	});
    
    
    	$(document).on('submit', '#formpreguntas', function(event) {
		
		
		$.ajax({
			url: 'funcs/preguntas.php',
			type: 'POST',
			dataType: 'JSON',
			data: { 'option' : 'guardar' ,  'data':$(this).serialize() },
			success:function(data){
				if(data=="ok"){
					toastr.info("Password Actualizado =) con exito .");
					setTimeout(function(){
						location.href="home.php";
					},2000);
				}
				else{
					toastr.warning("password > 8 letras, y deben ser los campos iguales");
				}
			}
		})
		event.preventDefault();
	});
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	});
















</script>




<?php 

}
 ?>