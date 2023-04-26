<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: gray;
        color: white;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
        display: none;
        }

        .loading--show {
        display: flex;
        }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {

      // Lista de urls que deseas precargar
      const LIST_IMAGES_PRELOAD = ["imgcarga/1.jpg", "imgcarga/2.jpg"];
      // Elemento visual del loading
      const LOADING = document.querySelector('.loading');
      // Obtiene elemento donde serán precargadas las imágenes
      const CONTAINER_IMAGES_PRELOAD = document.querySelector('#preload-images');
      // Tiempo de espera entre revisiones en ms
      const SLEEP_CHECK = 50;

      // Create una imagen por cada elemento de la lista LIST_IMAGES_PRELOAD y la guarda en el elemento CONTAINER_IMAGES_PRELOAD

      function makePreloadImages() {

        LIST_IMAGES_PRELOAD.forEach(urlImg => {
          // Crea la imagen
            const IMG_PRELOAD = document.createElement('img');
            // Añade su ruta
            IMG_PRELOAD.src = urlImg;
            // Oculta para que no se muestre
            IMG_PRELOAD.style = 'display: none';
            // Añade al contenedor
            CONTAINER_IMAGES_PRELOAD.appendChild(IMG_PRELOAD);
        });
      }


      // Herramienta para esperar un tiempo determinado en una función asíncrona

      function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      }

      // Comprueba de forma recursiva si todas las imágenes se han completado
      // Si todas estan descargadas, quitará la clase 'loading--show' a 'loading' para ocultarlo

      async function checkIfAllImagesCompleted() {

        // Obtiene todas las imágenes sin completar
        const NO_COMPLETES = Array.from(CONTAINER_IMAGES_PRELOAD.querySelectorAll('img')).filter((img) => {
            return !img.complete;
        });

        if (NO_COMPLETES.length !== 0) {
          // Vuelve a iterar si existe alguna sin completar
          await sleep(SLEEP_CHECK);
          return checkIfAllImagesCompleted();
        } else {
          // Oculta el loading
          LOADING.classList.remove('loading--show');
        } 
        return true;
      }


      // Inicia
              
      makePreloadImages();
      checkIfAllImagesCompleted();

    });

  </script>
</head>
<body>
        
    <?php 
    	include("conexion.php");

   /** /*Datos de conexion a la base de datos
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "test_empleados"; */

    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if(mysqli_connect_errno()){
        echo 'No se pudo conectar a la base de datos : '.mysqli_connect_error();
    }
    $nombrearchivo= date("Y-m-d");
    $sql = mysqli_query($con, "SELECT * FROM pqrs ORDER BY codigo ASC");
    $file = fopen("Enviar_correos_de_".$nombrearchivo.".txt", "w");

    while($row = mysqli_fetch_assoc($sql)){
        $linea = $row['codigo'].','.$row['nombres'] . ',' .$row['codigo'] . ',' . $row['direccion'] . ',' . $row['estado'] . ',' . $row['Fecha_Creacion'] . ',' . $row['email'] . "\n";
        fwrite($file, $linea);
    }
        fclose($file);




    mysqli_close($con);

    ?>
    <div title="Click para Cerrar" id="carga" style="cursor:pointer;border-radius:10px;-moz-border-radius:10px;-webkit-border-radius:10px;box-shadow:inset # 696763 0px 0px 14px;background-position:center;background-size:100%;background-color:# fff;width:300px;color:# fff;text-align:center;height:170px;padding:52px 12px 12px 12px;position:fixed;top:30%;left:40%;z-index:6;">
       Cargando<br> <img AlternateText="Loading" style="width: 150px; height: 150px;" src='imgcarga/giphy.gif' />
    </div>


    <meta http-equiv="refresh" content="5; url=index.php">
    <script type="text/javascript">
function cargando() {
    $("# carga").animate({ "opacity": "1" }, 1000, function () { $("# carga").css("display", "Block"); });

}

function cerrar() {
    $("# carga").animate({ "opacity": "0" }, 1000, function () { $("# carga").css("display", "none"); });
}

$(document).ready(function () {
    window.onload = cerrar;
    $("# carga").click(function () { cerrar(); });
    window.onbeforeunload = cargando;
});       
</script>
</body>
</html>
