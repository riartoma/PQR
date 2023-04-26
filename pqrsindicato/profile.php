<?php
	include("conexion.php");
	session_start();
    if (!isset($_SESSION['tiempo'])) {
        $_SESSION['tiempo']=time();
    }
    else if (time() - $_SESSION['tiempo'] > 3600) {
        session_destroy();
        /* Aquí redireccionas a la url especifica */
        header("Location: index.html");
        die();  
    }
    $_SESSION['tiempo']=time();
   
  // Controlo si el usuario ya está logueado en el sistema.
  if(isset($_SESSION['email'])){
  
?>
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de PQR</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("nav.php");
		
		if($_SESSION["tipo"]==1){
			?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del PQR &raquo; </h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			
			$sql = mysqli_query($con, "SELECT * FROM pqrs WHERE codigo='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM pqrs WHERE codigo='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM pqrs WHERE codigo='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			/**
			 * if(isset($_GET['aksi']) == 'delete'){
				$delete = mysqli_query($con, "DELETE FROM pqrs WHERE codigo='$nik'");
				if($delete){
					echo '<div class="alert alert-danger alert-dismissable">><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data berhasil dihapus.</div>';
				}else{
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data gagal dihapus.</div>';
				}
			}
			 */
			?>
			
			<table class="table table-striped table-condensed">
				
				<tr>
					<th>Nombre del PQR</th>
					<td><?php echo $row['nombres']; ?></td>
				</tr>
				<tr>
					<th>Descripcion</th>
					<td><?php echo $row['direccion']; ?></td>
				</tr>
				<!--
				<tr>
					<th>Lugar y Fecha de Nacimiento</th>
					<td><?php //echo $row['lugar_nacimiento'].', '.$row['fecha_nacimiento']; ?></td>
				</tr>
				<tr>
					<th>Dirección</th>
					<td><?php //echo $row['direccion']; ?></td>
				</tr>
				<tr>
					<th>Teléfono</th>
					<td><?php //echo $row['telefono']; ?></td>
				</tr>
				<tr>
					<th>Puesto</th>
					<td><?php //echo $row['puesto']; ?></td>
				</tr>
				-->
				<tr>
					<th>Estado</th>
					<td>
						<?php 
							if ($row['estado']==1) {
								echo "Queja";
							} else if ($row['estado']==2){
								echo "Reclamo";
							} else if ($row['estado']==3){
								echo "Peticion";
							}
						?>
					</td>
				</tr>
				
			</table>
			
			<a href="index.php" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Regresar</a>
			<?php
										if($_SESSION["tipo"]==4){

			?><a href="edit.php?nik=<?php echo $_GET["nik"]; ?>" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar datos</a>
						<a href="profile.php?aksi=delete&nik=<?php echo $_GET["nik"]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de borrar los datos <?php echo $row['nombres']; ?>')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</a>

						<?php }?>
		</div>
	</div>
	<?php }?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
	}else{
		// Si no está logueado lo redireccion a la página de login.
		header("HTTP/1.1 302 Moved Temporarily"); 
		header("Location: add.php"); 
	  }
 ?>