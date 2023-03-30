<?php
include("conexion.php");

// Consulta SQL para extraer los datos de la tabla
$sql = "SELECT MONTH(Fecha_Creacion) AS mes, estado, CAST(SUM(estado) / CASE estado WHEN 1 THEN 1 WHEN 2 THEN 2 WHEN 3 THEN 3 END AS INT) AS cantidad_total FROM empleados WHERE estado IN (1, 2, 3) AND Fecha_Creacion BETWEEN '2023-03-01' AND '2023-04-30' GROUP BY mes, estado";
$resultado = mysqli_query($con, $sql);

if (mysqli_num_rows($resultado) > 0) {
    // Inicializar el array multidimensional para almacenar los datos
    $datos_meses = array(
        "1" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "2" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "3" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "4" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "5" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "6" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "7" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "8" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "9" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "10" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "11" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0),
        "12" => array("Peticion" => 0, "Queja" => 0, "Reclamo" => 0)
    );

    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Almacenar la cantidad total en el array multidimensional
        $mes = $fila["mes"];
        $estado = $fila["estado"];
        $cantidad_total = $fila["cantidad_total"];

        if ($estado == 1) {
            $datos_meses[$mes]["Peticion"] = $cantidad_total;
        } elseif ($estado == 2) {
            $datos_meses[$mes]["Queja"] = $cantidad_total;
        } elseif ($estado == 3) {
            $datos_meses[$mes]["Reclamo"] = $cantidad_total;
        }
    }

   
          
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
</style>

</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
    <br><hr><br>

    <center>
    <div style="border: 5px solid darkblue; height: 300px; width: 600px; align:center " >
<canvas id="grafico" ></canvas>
    </div></center>
<script>
// Obtener los datos desde PHP y convertirlos en un objeto JavaScript
var datos_meses = <?php echo json_encode($datos_meses); ?>;
var etiquetas = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

// Crear el array de datasets para el gráfico
var datasets = [];

// Iterar sobre los datos de cada tipo de estado (peticion, queja, reclamo)
Object.keys(datos_meses[1]).forEach(function(estado) {
  // Crear un array para almacenar los datos de cada estado
  var datos_estado = [];

  // Iterar sobre los datos de cada mes
  Object.keys(datos_meses).forEach(function(mes) {
    datos_estado.push(datos_meses[mes][estado]);
  });

  // Crear un dataset para el estado actual
  datasets.push({
    label: estado,
    data: datos_estado,
    borderColor: getRandomColor(),
    borderWidth: 2,
    fill: false
  });
});

// Crear el gráfico usando los datos y opciones deseadas
var ctx = document.getElementById('grafico').getContext('2d');
var grafico = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: etiquetas,
    datasets: datasets
  },
  options: {
    responsive: true,
    title: {
      display: true,
      text: 'Cantidad de solicitudes por mes'
    },
    tooltips: {
      mode: 'index',
      intersect: false
    },
    hover: {
      mode: 'nearest',
      intersect: true
    },
    scales: {
      xAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Mes'
        }
      }],
      yAxes: [{
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Cantidad'
        },
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});

// Función para generar colores aleatorios
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
</script>
<br><br><hr><br><br>
<center>
  <table>
    <thead>
      <tr>
        <th>Mes</th>
        <th>Petición</th>
        <th>Queja</th>
        <th>Reclamo</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($datos_meses as $mes => $cantidad) { ?>
        <tr>
          <td><?php echo $mes; ?></td>
          <td><?php echo $cantidad["Peticion"]; ?></td>
          <td><?php echo $cantidad["Queja"]; ?></td>
          <td><?php echo $cantidad["Reclamo"]; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</center>
<?php 
  
} else {
  // Si no se encontraron datos, mostrar un mensaje de error
  echo "No se encontraron datos para el mes actual.";
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?><br>
<center><p>&copy; Ricardo Arturo Torres Manrique <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <br>
	
</body>
</html>



       
