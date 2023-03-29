<?php
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Listado de PQR</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM empleados WHERE codigo='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

<form class="form-inline" method="get" >
	
      <label>Fecha Desde:</label>
      <input type="date" class="form-control" placeholder="Start"  name="date1"/>
      <label>Hasta</label>
      <input type="date" class="form-control" placeholder="End"  name="date2"/>
	  <select name="filter" class="form-control" >
						<option value="0">Tipo de PQR</option>
						<?php $filter = (isset($_GET['tipo']) ? $_GET['date1'] : NULL);  ?>
						<option value="1" <?php if($filter != NULL){ echo 'selected'; } ?>>Peticion</option>
						<option value="2" <?php if($filter != NULL){ echo 'selected'; } ?>>Queja</option>
                        <option value="3" <?php if($filter != NULL){ echo 'selected'; } ?>>Reclamo</option>
					</select>
					<input class="btn btn-primary" type="submit" value="Enviar">

      <!-- <button class="btn btn-primary" name="filter"><span class="glyphicon glyphicon-search"></span></button> <a href="index2.php" type="button" class="btn btn-success"><span class = "glyphicon glyphicon-refresh"><span></a> -->
    </form>
	<?php
	echo "aca estara la leyenda buscada";
	?>

			<!-- //aca esta el filtro anterior que se uso 
			<form class="form-inline" method="get">
			<div class="form-group">
					<label class="col-sm-3 control-label">Fecha inicial</label>
					<div class="col-sm-4">
						<input type="text" name="fecha_inicial" class="input-group date form-control" date="" data-date-format="dd-mm-yyyy" placeholder="00-00-0000" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha Final</label>
					<div class="col-sm-4">
						<input type="text" name="fecha_final" class="input-group date form-control" date="" data-date-format="dd-mm-yyyy" placeholder="00-00-0000" required>
					</div>
				</div>
				<a class="btn btn-primary" href="index2.php" role="button">Filtrar</a>
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de Tipo de PQR</option>
						<?php /* $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Peticion</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Queja</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; }  */?>>Reclamo</option>
					</select>
				
			<a class="btn btn-primary" href="index2.php" role="button">Filtrar entre fechas</a>
			</div> -->
			</form>
			
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>No</th>
<!--				<th>Código</th> -->
					<th>Nombre</th>
					<th>Peticion, Queja o Reclamo</th>
                    <!-- <th>Lugar de nacimiento</th>
                    <th>Fecha de nacimiento</th>
					<th>Teléfono</th>
					<th>Cargo</th> -->
					<th>Tipo</th>
					<th>Fecha de Creacion</th>
                    <th>Acciones</th>
				</tr>
				<?php
					//creamos la funcion para limitar el tamaño de una cadena muy larga de texto
					function limitar_cadena($cadena, $limite, $sufijo){
						// Si la longitud es mayor que el límite...
						if(strlen($cadena) > $limite){
							// Entonces corta la cadena y ponle el sufijo
							return substr($cadena, 0, $limite) . $sufijo;
						}
						
						// Si no, entonces devuelve la cadena normal
						return $cadena;
					}

					// Formas de uso
					# Limitar a 3 caracteres y si es más larga cortarla, agregándole puntos suspensivos
					//echo limitar_cadena("Hola mundo soy una cadena muy larga", 100, "...");
					

					if (isset($_GET["date1"]) && isset($_GET["date2"]) ){
				//if($filter==1 ){
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY Fecha_Creacion DESC") or die(mysqli_error());//='$filter' ORDER BY codigo ASC");
//echo "SELECT * FROM empleados WHERE Fecha_Creacion BETWEEN '".$_GET["date1"] ."' AND  '".$_GET["date2"]."'";
					//$sql = mysqli_query($con, "SELECT * FROM empleados WHERE estado='$filter' ORDER BY codigo ASC");
				}
				if (($_GET["date1"]!='') && ($_GET["date2"]!='') ){
					//if($filter==1 ){
	//echo "SELECT * FROM empleados WHERE Fecha_Creacion BETWEEN '".$_GET["date1"] ."' AND  '".$_GET["date2"]."'";
						//$sql = mysqli_query($con, "SELECT * FROM empleados WHERE estado='$filter' ORDER BY codigo ASC");
						if($_GET['filter']!=0){
							$sql = mysqli_query($con, "SELECT * FROM empleados WHERE Fecha_Creacion >= '".$_GET["date1"] ." 00:00:00' and  Fecha_Creacion <= '".$_GET["date2"] ." 23:59:59' and estado = ".(int)$_GET['filter']." ORDER BY Fecha_Creacion asc") or die(mysqli_error());//='$filter' ORDER BY codigo ASC");
						}
						else{
							$sql = mysqli_query($con, "SELECT * FROM empleados WHERE Fecha_Creacion >= '".$_GET["date1"] ." 00:00:00' and  Fecha_Creacion <= '".$_GET["date2"] ." 23:59:59' ORDER BY Fecha_Creacion asc") or die(mysqli_error());//='$filter' ORDER BY codigo ASC");

						}
					}else{
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					//aca mostramos los campos de la tabla a ver en el formulario 
					while($row = mysqli_fetch_assoc($sql)){
						
						//en este espacio despues de No va si se desea agregar el campo de codigo pero no es necesario /*<td>'.$row['codigo'].'</td>*/
						/* echo '
						<tr>
							<td>'.$no.'</td>
							
							<td><a href="profile.php?nik='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
                            <td>'.$row['lugar_nacimiento'].'</td>
                            <td>'.$row['fecha_nacimiento'].'</td>
							<td>'.$row['telefono'].'</td>
                            <td>'.$row['puesto'].'</td>
							<td>'; */
							echo '<td>'.$row['codigo'].'</td>
							<td><a href="profile.php?nik='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
							<td>'.limitar_cadena($row['direccion'], 100, "...")
							.'</td>
							<td>'
							;
							if($row['estado'] == '1'){
								echo '<span class="label label-success">Peticion</span>';
							}
                            else if ($row['estado'] == '2' ){
								echo '<span class="label label-info">Queja</span>';
							}
                            else if ($row['estado'] == '3' ){
								echo '<span class="label label-warning">Reclamo</span>';
							}
							echo '<td>'.$row['Fecha_Creacion'].'</td>';
						echo '
							</td>
							<td>

								<a href="edit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<p>&copy; Ricardo Arturo Torres Manrique <?php echo date("Y");
	/* $var1=$_GET["date1"];
	$var2=$_GET["date2"];
	if (isset($var1,$var2)) 
	{
    echo "Variables definidas!!!";
	}
	else
		{
		echo "Variables NO definidas!!!";
		} */
		
	
	?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
