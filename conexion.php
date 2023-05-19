
<?php  
// crear conexion con oracle
$conexion = oci_connect("Admindoc", "doc2023", "localhost/xepdb1"); 
 
if (!$conexion) {    
  $m = oci_error();    
  echo $m['message'], "n";    
  exit; 
} else {    
  echo "Conexión con éxito a Oracle!"; } 
 
?>
