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
  include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Latihan MySQLi</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
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
		<?php include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del PQR &raquo; Agregar datos</h2>
			<hr />

			<?php
			if(isset($_POST['add'])){
				//$codigo		     = mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));//Escanpando caracteres 
				$nombres		    = mysqli_real_escape_string($con,(strip_tags($_POST["nombres"],ENT_QUOTES)));//Escanpando caracteres 
				//$lugar_nacimiento	 = mysqli_real_escape_string($con,(strip_tags($_POST["lugar_nacimiento"],ENT_QUOTES)));//Escanpando caracteres 
				//$fecha_nacimiento	 = mysqli_real_escape_string($con,(strip_tags($_POST["fecha_nacimiento"],ENT_QUOTES)));//Escanpando caracteres 
				$direccion	     	= mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 
				//$telefono		 = mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				//$puesto		 = mysqli_real_escape_string($con,(strip_tags($_POST["puesto"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 	= mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
				$email	     		= mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));//Escanpando caracteres 

			

				$cek = mysqli_query($con, "SELECT * FROM pqrs "); //WHERE codigo='$codigo'
				//se comenta este if debido a que el codigo de cada una de las peticiones es unico y autoincremental
				//if(mysqli_num_rows($cek) == 0){
				$ins="INSERT INTO pqrs( nombres, direccion, estado, email) VALUES('".$nombres."',  '".$direccion."', '".$estado."', '".$email."')";
					$insert = mysqli_query($con, "INSERT INTO pqrs( nombres, direccion, estado, email)
					    VALUES('$nombres',  '$direccion', '$estado', '$email')") or die($ins);

						/* $insert = mysqli_query($con, "INSERT INTO empleados( nombres, lugar_nacimiento, fecha_nacimiento, direccion, telefono, puesto, estado)
															VALUES('$nombres', '$lugar_nacimiento', '$fecha_nacimiento', '$direccion', '$telefono', '$puesto', '$estado')") or die(mysqli_error());
						 */
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
							$educacion='educacion@sanandres.gov.co';
							$seguridadsocial='seguridadsocialasisap@gmail.com';
							$correo1='ratmanri@gmail.com';
							$correo2='ricardodocentepolitecnica@gmail.com							';

							//enviarCorreo1($educacion);
							//enviarCorreo1($seguridadsocial);
							//enviarCorreo1($correo1);
							//enviarCorreo1($correo2);
							enviarCorreo1($_POST["email"],$correo1, $correo2);



						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
					 
				//}else{
					//echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. código exite!</div>';
				//}
			}
			?>

			<form class="form-horizontal" action="" method="post">
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombres</label>
					<div class="col-sm-4">
						<input type="text" name="nombres" class="form-control" placeholder="Nombres" required>
					</div>
				</div>
				<!-- <div class="form-group">
					<label class="col-sm-3 control-label">Lugar de nacimiento</label>
					<div class="col-sm-4">
						<input type="text" name="lugar_nacimiento" class="form-control" placeholder="Lugar de nacimiento" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de nacimiento</label>
					<div class="col-sm-4">
						<input type="text" name="fecha_nacimiento" class="input-group date form-control" date="" data-date-format="dd-mm-yyyy" placeholder="00-00-0000" required>
					</div>
				</div> -->
				<div class="form-group">
					<label class="col-sm-3 control-label">Peticion, Queja o Reclamo</label>
					<div class="col-sm-3">
						<textarea name="direccion" class="form-control" placeholder="Ingrese aca su PQR especificando si es posible lo sucedido a detalle "></textarea>
					</div>
				</div>
				<!-- <div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-3">
						<input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Puesto</label>
					<div class="col-sm-3">
						<input type="text" name="puesto" class="form-control" placeholder="Puesto" required>
					</div>
				</div> -->
				

				<div class="form-group">
					<label class="col-sm-3 control-label">Tipo</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option value=""> ----- </option>
                           	<option value="1">Queja</option>
							<option value="2">Reclamo</option>
							<option value="3">Peticion</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Correo Electronico para recibir respuesta del PQR</label>
					<div class="col-sm-4">
						<input type="email" name="email" class="form-control" placeholder="Email" required>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="index.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
			<div>
				<h3>cuando de click en el boton de guardar datos espere un momento mientras se procesa su peticion y se envia el correo pertiente tanto a el sindicato como a usted mismo para poder verificar que su pqr se guardo 
					de ser necesario nos comunicaremos con usted para aclarar o afiianzar la informacion posteriormente.
				</h3>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>

	<?php 
		function enviarCorreo1($correoUsuario, $correoeducacion, $correoseguridad) {
			//librerias otro que funciona
			require 'librerias/PHPMailer/PHPMailerAutoload.php';
			//Create a new PHPMailer instance
			$mail = new PHPMailer();
			$mail->IsSMTP();
			
			//Configuracion servidor mail
			$mail->From = "ricardoarturotorres@gmail.com"; //remitente
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls'; //seguridad
			$mail->Host = "smtp.gmail.com"; // servidor smtp
			$mail->Port = 587; //puerto
			$mail->Username =$correoUsuario; //nombre usuario
			$mail->Password = 'qtmi uaah qcji wkrl'; //contraseña
			
			//Agregar destinatario
			$mail->AddAddress($correoUsuario);
			$asunto = "Este mensaje es de prueba"; 
			$mail->Subject = $asunto;
			$cuerpo = '
				<html> 
				<head> 
				<title>hola '.$_POST['nombres'].'</title> 
				</head> 
				<body> 
				<h1>Muchas gracias por registrar su PQR en esta pagina!</h1> 
				<p> 
				<b>Le informaremos de forma oportuna en el momento que podamos solucionar su PQR </b>. 
				En caso de ser necesario nos comunicaremos por usted por este medio electronico. 
				</p> 
				Su PQR:'.$_POST['direccion'].'
				<br><br>

				Se recibio su PQR satisfactoriamente

				<br><br>

				</body> 
				</html> 
				'; 
			$mail->Body = $cuerpo;
			
			//Avisar si fue enviado o no y dirigir al index
			if ($mail->Send()) {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! se realizo el envio de los correos. a '.$_POST['email'].'</div>';

				echo'<script type="text/javascript">
						alert("Correo Enviado Correctamente");
					</script>';
			} else {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>no se realizo el envio del correo.</div>';

				echo'<script type="text/javascript">
						alert("El Correo NO FUE ENVIADO, intentar de nuevo");
					</script>';
					echo '  <META HTTP-EQUIV="REFRESH" CONTENT="1;URL=add.php">';
					
			}
			
/*
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			
			try {
				// Configuración del servidor SMTP
				$mail->isSMTP();
				$mail->SMTPDebug = 0; // 0 para desactivar la depuración SMTP
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl'; // TLS o SSL según corresponda
				$mail->Host = 'mail.apesigam.com'; // Servidor SMTP de Gmail
				$mail->Port = 465; // Puerto SMTP de Gmail
				$mail->Username = 'pruebas@apesigam.com'; //Cambiar por tu cuenta de Gmail
				$mail->Password = '75104962Qw.,-'; //Cambiar por tu contraseña de Gmail
				
				// Configuración del correo electrónico
				$asunto = "Este mensaje es de prueba"; 
	
				//Configuración del correo electrónico
				$mail->setFrom('pruebas@apesigam.com', 'Ricardo torres'); //Cambiar por tu cuenta de Gmail y tu nombre
				$mail->addAddress($correo, 'otro correo mio'); //Cambiar por la dirección de correo electrónico del destinatario y su nombre
				$mail->Subject = $asunto;
				$cuerpo = '
					<html> 
					<head> 
					<title>Prueba de correo</title> 
					</head> 
					<body> 
					<h1>Hola amigos!</h1> 
					<p> 
					<b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje. 
					</p> 
					</body> 
					</html> 
					'; 
				$mail->Body = $cuerpo;
				
				// Envío del correo electrónico
				$mail->send();
				//var_dump($mail);
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! se realizo el envio de los correos.</div>';
				return true;
			} catch (Exception $e) {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>no se realizo el envio de los correos.</div>';
	
				return false;
			}*/
			$mail1 = new PHPMailer();
			$mail1->IsSMTP();
			
			//Configuracion servidor mail
			$mail1->From = "ricardoarturotorres@gmail.com"; //remitente
			$mail1->SMTPAuth = true;
			$mail1->SMTPSecure = 'tls'; //seguridad
			$mail1->Host = "smtp.gmail.com"; // servidor smtp
			$mail1->Port = 587; //puerto
			$mail1->Username =$correoeducacion; //nombre usuario
			$mail1->Password = 'qtmi uaah qcji wkrl'; //contraseña
			
			//Agregar destinatario
			$mail1->AddAddress($correoeducacion);
			$asunto1 = "Este mensaje es de prueba"; 
			$mail1->Subject = $asunto1;
			$cuerpo1 = '
				<html> 
				<head> 
				<title>hola '.$_POST['nombres'].'</title> 
				</head> 
				<body> 
				<h1>Muchas gracias por registrar su PQR en esta pagina!</h1> 
				<p> 
				<b>Le informaremos de forma oportuna en el momento que podamos solucionar su PQR </b>. 
				En caso de ser necesario nos comunicaremos por usted por este medio electronico. 
				</p> 
				Su PQR:'.$_POST['direccion'].'
				<br><br>

				Se recibio su PQR satisfactoriamente

				<br><br>

				</body> 
				</html> 
				'; 
			$mail1->Body = $cuerpo1;
			if ($mail1->Send()) {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! se realizo el envio de los correos. a educacion</div>';

				echo'<script type="text/javascript">
						alert("Correo Enviado Correctamente");
					</script>';
			} else {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>no se realizo el envio del correo. educacion</div>';

				echo'<script type="text/javascript">
						alert("El Correo NO FUE ENVIADO, intentar de nuevo");
					</script>';
					echo '  <META HTTP-EQUIV="REFRESH" CONTENT="1;URL=add.php">';
					
			}





			$mail2 = new PHPMailer();
			$mail2->IsSMTP();
			
			//Configuracion servidor mail
			$mail2->From = "ricardoarturotorres@gmail.com"; //remitente
			$mail2->SMTPAuth = true;
			$mail2->SMTPSecure = 'tls'; //seguridad
			$mail2->Host = "smtp.gmail.com"; // servidor smtp
			$mail2->Port = 587; //puerto
			$mail2->Username =$correoseguridad; //nombre usuario
			$mail2->Password = 'qtmi uaah qcji wkrl'; //contraseña
			
			//Agregar destinatario
			$mail2->AddAddress($correoseguridad);
			$asunto2 = "Este mensaje es de prueba"; 
			$mail2->Subject = $asunto2;
			$cuerpo2 = '
				<html> 
				<head> 
				<title>hola '.$_POST['nombres'].'</title> 
				</head> 
				<body> 
				<h1>Muchas gracias por registrar su PQR en esta pagina!</h1> 
				<p> 
				<b>Le informaremos de forma oportuna en el momento que podamos solucionar su PQR </b>. 
				En caso de ser necesario nos comunicaremos por usted por este medio electronico. 
				</p> 
				Su PQR:'.$_POST['direccion'].'
				<br><br>

				Se recibio su PQR satisfactoriamente

				<br><br>

				</body> 
				</html> 
				'; 
			$mail2->Body = $cuerpo2;

			if ($mail2->Send()) {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! se realizo el envio de los correos. a seguridad</div>';

				echo'<script type="text/javascript">
						alert("Correo Enviado Correctamente");
					</script>';
			} else {
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>no se realizo el envio del correo. seguridad</div>';

				echo'<script type="text/javascript">
						alert("El Correo NO FUE ENVIADO, intentar de nuevo");
					</script>';
					echo '  <META HTTP-EQUIV="REFRESH" CONTENT="1;URL=add.php">';
					
			}

		}
		
	function enviodemailconphpmailer(){
		$mail = new PHPMailer(true);
		
		try {
			//Configuración del servidor SMTP de Gmail
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'ricardodocentepolitecnica@gmail'; //Cambiar por tu cuenta de Gmail
			$mail->Password = '75104962Qw.,-'; //Cambiar por tu contraseña de Gmail
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$asunto = "Este mensaje es de prueba"; 

			//Configuración del correo electrónico
			$mail->setFrom('ricardodocentepolitecnica@gmail.com', 'Ricardo torres'); //Cambiar por tu cuenta de Gmail y tu nombre
			$mail->addAddress('ratmanri@ejemplo.com', 'otro correo mio'); //Cambiar por la dirección de correo electrónico del destinatario y su nombre
			$mail->Subject = $asunto;
			$cuerpo = '
				<html> 
				<head> 
				<title>Prueba de correo</title> 
				</head> 
				<body> 
				<h1>Hola amigos!</h1> 
				<p> 
				<b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje. 
				</p> 
				</body> 
				</html> 
				'; 
			$mail->Body = $cuerpo;
		
			//Envío del correo electrónico
			$mail->send();
			echo 'El correo electrónico ha sido enviado';
		} catch (Exception $e) {
			echo 'El correo electrónico no pudo ser enviado. Error: ', $mail->ErrorInfo;
		}
	}
	var_dump($_SESSION["tipo"]);
	?>

	
</body>
</html>
