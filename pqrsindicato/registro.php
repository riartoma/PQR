<!-- 
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="inicio.css" />
    <title>Mi Propia Web</title>
  </head>
  <body>
       <!--<a href="http://www.pqrsindicato.com">Website</a>
        <META HTTP-EQUIV="REFRESH" CONTENT="1;URL=http://www.pqrsindicato.com">
        -- >
  <META HTTP-EQUIV="REFRESH" CONTENT="1;URL=index.php">

  </body>
</html>
-->

<!DOCTYPE html>
<html>
  <head>
    <title>Login en PHP</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>
      .container{margin-top:100px}
    </style>
    
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
  <div id="contenedor">
  <div id="contenedorcentrado">

  <div id="login">

      <form class="form-horizontal" action="registrar.php" method="post">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email" required>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">registrarse</button>
          </div>
        </div>
      </form>
    </div>
    <div id="derecho">
    <div class="titulo">
        Bienvenido
    </div>
    <hr>
    <div class="pie-form">
        <a href="#">¿Perdiste tu contraseña?</a>
        <a href="#">¿No tienes Cuenta? Registrate</a>
        <hr>
        <a href="#">« Volver</a>
    </div>
</div>

    </div>
    </div>
  </body>
</html>