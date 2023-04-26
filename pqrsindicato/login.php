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
 
  // Obtengo los datos cargados en el formulario de login.
  $email = $_POST['email'];
  $password = md5($_POST['password']);
   include("conexion.php");
    $sql="SELECT * FROM logeo where email='$email' and pass='$password'";
   $resultado = mysqli_query($con, $sql);

    while($row = mysqli_fetch_assoc($resultado)){

        if(mysqli_num_rows($resultado) > 0){
            echo '<tr><td colspan="8">si hay datos.</td></tr>';
        }

        if($row['tipo']==1 || $row['tipo']==4){
            $_SESSION['email'] = $row["email"];
            $_SESSION['tipo'] = $row['tipo'];
            //echo "Se esta Rediriguiendo a la pagina correcta espere un momento. ";

            echo '<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=index.php">';
        }
        if($row['tipo']==2){
            $_SESSION['email'] = $row["email"];
            $_SESSION['tipo'] = $row['tipo'];
            //echo "Se esta Rediriguiendo a la pagina correcta espere un momento. ";

            echo '<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=index.php">';
        }
        if($row['tipo']==3){
            $_SESSION['email'] = $row["email"];
            $_SESSION['tipo'] = $row['tipo'];
            //echo "Se esta Rediriguiendo a la pagina correcta espere un momento. ";

            echo '<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=index.php">';
        }
        if($row['tipo']==4){
            $_SESSION['email'] = $row["email"];
            $_SESSION['tipo'] = $row['tipo'];
            //echo "Se esta Rediriguiendo a la pagina correcta espere un momento. ";

            echo '<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=index.php">';
        }
        else{
            echo 'El email o password es incorrecto, vuelva a intenarlo.<br/>';
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=add.php">';
        }

    }
    

  // Esto se puede remplazar por un usuario real guardado en la base de datos.
  /**
   * if($email == 'email@dominio.com' && $password == '1234'){
    // Guardo en la sesión el email del usuario.
    $_SESSION['email'] = $email;
     
    // Redirecciono al usuario a la página principal del sitio.
    header("HTTP/1.1 302 Moved Temporarily"); 
    header("Location: principal.php"); 
  }else{
    echo 'El email o password es incorrecto, <a href="index.html">vuelva a intenarlo</a>.<br/>';
  }

   */
 
?>