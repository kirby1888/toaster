<?php

class controlDB{
    
    
    function __construct(){
        try{
            
            $host= "localhost";
            $db_name="prueba";
            $user="root";
            $pass="";
            
            $this->con=mysqli_connect($host,$user,$pass) or die("error en la conexion");
            
            mysqli_select_db($this->con,$db_name)or die ("no se ha seleccionado una bd");
            
        }
        catch (exception $ex){
            
            throw $ex;
            
        }
            
            
            
        }
        
        
    function consulta($sql)
    {
      $res = mysqli_query($this->con,$sql);
        
        $data=NULL;
        while($fila=mysqli_fetch_assoc($res))
        {
            
            $data[]=$fila;
            
            
            
        }
        
        
        return $data;
        
        
    }
       
        
    function actualizar($sql){
        
        mysqli_query($this->con,$sql);
        
        if(mysqli_affected_rows($this->con)<=0){
            
            echo "no se puede realizar";
            
            
        }else {
            
            
            echo "se ha realizado exitosamenye ";
            
        }
        
        
    }    
    
    
    
    
    
    
    
    
    }
    
    
    
    
    
    
    
    





?>