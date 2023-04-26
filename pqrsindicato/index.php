<?php
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
    // Le doy la bienvenida al usuario.
  
?>


<?php

include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de pqr</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

	<!-- jsPDF library -->
<script src="js/jspdf.min.js"></script>
    <!--aca van los stilos de la pagina-->
    <style>
		.content {
			margin-top: 80px;
		}
	
        table {
        border-collapse: collapse;
        margin: auto;
        width: 80%;
        }

        th, td {
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        }

        th {
        background-color: #f2f2f2;
        font-weight: bold;
        }

        tr:nth-child(even) {
        background-color: #f2f2f2;
        }
        #exportar-pdf {
        display: block;
        margin: 20px auto;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
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
			?>

			<form class="form-inline" method="get">
				<div class="form-group">
				<?php 
				if(isset($_SESSION['email']) && ($_SESSION['tipo']==1 || $_SESSION['tipo']==4)){
					?>
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de Tipo de PQR</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Peticion</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Queja</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Reclamo</option>
					</select>
				
			<a class="btn btn-primary" href="index2.php?date1=&date2=&filter=0" role="button">Filtrar entre fechas</a>
			</div>
			</form>
			<br>
			
					<a href="graficos3.php" class="btn btn-primary" role="button">graficos 2022</a>
			<a href="graficos2.php" class="btn btn-primary" role="button">graficos 2023</a>
			<a href="graficos4.php" class="btn btn-primary" role="button">graficos 2024</a>
			<a href="graficos5.php" class="btn btn-primary" role="button">graficos 2025</a>

			<?php
				}	
				if($_SESSION["tipo"]==4){
					
					?>
					<a href="demonioprogramado.php" class="btn btn-primary" role="button">demonio</a>
			<?php
				}
			?>
						<button id="exportButton" class="btn btn-info btn-sm" onclick="exportTableYGraficoToPDF()"> Exportar Tabla a PDF</button>

			<br>
			<!-- aca colocamos la cantidad de años que necesitemos los graficos por ahora luego se encontrara una solucion mas elegante-->
			


			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover" id="table-and-graph">
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

					 
					if(isset($_SESSION['email'])){
						if(($_SESSION['tipo']==1 || $_SESSION['tipo']==4)){
							if($filter){
								$sql = mysqli_query($con, "SELECT * FROM pqrs WHERE estado='$filter' ORDER BY codigo ASC");
							}else{
								$sql = mysqli_query($con, "SELECT * FROM pqrs ORDER BY codigo ASC");
							}
						}else{
							$sql = mysqli_query($con, "SELECT * FROM pqrs ORDER BY codigo ASC");
						}
					}else{
						$sql = mysqli_query($con, "SELECT * FROM pqrs ORDER BY codigo ASC");
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
							//echo '<td>'.$no.'</td>
							echo '<td>'.$row['codigo'].'</td>
							<td><a href="profile.php?nik='.$row['codigo'].'" tittle="Ver datos"><span class="glyphicon glyphicon-user" aria-hidden="true" ></span> '.$row['nombres'].'</a></td>
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
							';
							if($_SESSION["tipo"]==4){
							echo '
								<a href="edit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm " style="display: inline-block;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								';
								

								echo '
								<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar Datos" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm" style="display: inline-block;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
								}
								echo '
								<a href="profile.php?nik='.$row['codigo'].'" title="Ver Datos" class="btn btn-sucess btn-sm " style="display: inline-block;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
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
	<p>&copy; Ricardo Arturo Torres Manrique <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
       function exportTableYGraficoToPDF() {
			var pdf = new jsPDF('p', 'pt', 'letter');
			var source = document.getElementById('table-and-graph');

			// Configuración de estilos y opciones de la tabla
			var specialElementHandlers = {
				'#bypassme': function(element, renderer) {
				return true;
				}
			};

			var margins = {
				top: 50,
				bottom: 60,
				left: 40,
				width: 522
			};

		
			
			// Agregar un rectángulo transparente para crear un espacio en blanco

			pdf.text(200, 50, 'Tabla especificando dichos resultados!');
			// Agregar la tabla HTML al documento PDF
			pdf.fromHTML(
				source, // elemento HTML
				margins.left, // margen izquierdo
				margins.top + 20, { // Cambie 220 por la altura deseada para la tabla
				'width': margins.width,
				'elementHandlers': specialElementHandlers
				},

				// Callback después de agregar la tabla
				function(dispose) {
				// Descargar el documento PDF
				pdf.save('tabla.pdf');

				}, margins
			);
		} 
</script>
</body>
</html>
<?php
	}else{
		// Si no está logueado lo redireccion a la página de login.
		header("HTTP/1.1 302 Moved Temporarily"); 
		header("Location: add.php"); 
	  }
	?>
