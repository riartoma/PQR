	<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand visible-xs-block visible-sm-block" href="">Inicio</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav ">
					<?php if(isset($_SESSION['email'])){
				if($_SESSION['tipo']==1 || $_SESSION['tipo']==4 ){
					?>
					<li class="active"><a href="index.php">Listado de PQR</a></li>
				<?php }
				?>
				<li><a href="add.php">Agregar PQR</a></li>
<?php 
				// Le doy la bienvenida al usuario.
				echo '<li><a href="">Bienvenido <strong>' . $_SESSION['email'] . '</strong></a></li>, 
				<li><a href="cerrar-sesion.php">cerrar sesión</a></li>';
			}else{?>

				<li><a href="index.html">iniciar sesión</a></li>
<?php
			}
  			?>
				</ul>
			</div><!--/.nav-collapse -->
	</div>