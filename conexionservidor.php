<?php
/*Datos de conexion a la base de datos*/
$db_host = "localhost";
$db_user = "id20374481_root";
$db_pass = "75104962Qw.,-";
$db_name = "id20374481_test_empleados";

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()){
	echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
}
?>