<?php
/*Datos de conexion a la base de datos*/
$db_host = "outman.iad1-mysql-e2-3b.dreamhost.com";
$db_user = "pqr";
$db_pass = "75104962Qw.,-";
$db_name = "pqrsanandres";

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()){
	echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
}
?>

outman.iad1-mysql-e2-3b.dreamhost.com