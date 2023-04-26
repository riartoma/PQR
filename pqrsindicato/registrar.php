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
    $sql="INSERT INTO logeo(email,pass,tipo) VALUES ('$email','$password',2)";
   $resultado = mysqli_query($con, $sql)or die($sql);


    var_dump($resultado);
            echo 'Se registro el nuevo usuario .<br/>';
           // echo '<META HTTP-EQUIV="REFRESH" CONTENT="2;URL=index.html">';
        
    

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