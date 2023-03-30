<?php
include("conexion.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap 
	<link href="css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="css/style_nav.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
    
    
<?php 
// Convertir las fechas a formato legible para Chart.js


function limitar_cadena($cadena, $limite, $sufijo){
    // Si la longitud es mayor que el límite...
    if(strlen($cadena) > $limite){
        // Entonces corta la cadena y ponle el sufijo
        return substr($cadena, 0, $limite) . $sufijo;
    }
    
    // Si no, entonces devuelve la cadena normal
    return $cadena;
}
echo "<br><br><br>";

// Consulta SQL para extraer los datos de la tabla
$sql12 = "SELECT nombres, estado, Fecha_Creacion FROM empleados ORDER BY Fecha_Creacion";
/*
SELECT month(Fecha_Creacion), SUM(estado) , estado from empleados  where estado =1 GROUP BY estado, Fecha_Creacion LIMIT 0, 2500;
SELECT month(Fecha_Creacion), SUM(estado)/2 , estado from empleados  where estado =2 GROUP BY estado, Fecha_Creacion LIMIT 0, 2500;
SELECT month(Fecha_Creacion), SUM(estado)/3 , estado from empleados  where estado =3 GROUP BY estado, Fecha_Creacion LIMIT 0, 2500;*/
$sql = "SELECT MONTH(Fecha_Creacion) AS mes, estado, CAST(SUM(estado) / CASE estado WHEN 1 THEN 1 WHEN 2 THEN 2 WHEN 3 THEN 3 END AS INT) AS cantidad_total FROM empleados WHERE estado IN (1, 2, 3) AND Fecha_Creacion BETWEEN '2023-03-01' AND '2023-03-30' GROUP BY mes, estado";
$resultado = mysqli_query($con, $sql);
if (mysqli_num_rows($resultado) > 0) {
    // Procesar los resultados
    $nombres = array();
    $estados = array();
    $fechas = array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
        //$nombres[] = $fila["nombres"];
        /*if($fila["estado"]==1){
            $fila["estado"]="Peticion";
        }
        if($fila["estado"]==2){
            $fila["estado"]="Queja";
        }
        if($fila["estado"]==3){
            $fila["estado"]="Reclamo";
        }*/
        $cantidadtotal=$fila["cantidad_total"];
        $estados[] = $fila["estado"];
        $fechas[] = $fila["mes"];
    }
} else {
    echo "No se encontraron resultados.";
}
// Convertir las fechas a formato legible para Chart.js
$fechas_legibles = array();
foreach ($fechas as $fecha) {
    $fechas_legibles[] = date("Y-m-d", strtotime($fecha));
}
// Crear un array con los datos para Chart.js
$datos = array(
    "labels" => $estados,
    "datasets" => array(
        array(
            "label" => "en el mes de marzo",
            "data" => $cantidadtotal,
            "backgroundColor" => "rgba(75,192,192,0.4)",
            "borderColor" => "rgba(75,192,192,1)",
            "borderWidth" => 1
        )
    )
);

// Convertir los datos a formato JSON
$datos_json = json_encode($datos);
?>
<div class="container-fluid">
    <div class="row text-white text-center">

        <div class="col-5 bg-dark border" style="border: 5px solid darkblue; height: 300px; width: 600px;">
                <canvas id="grafico"></canvas>
        </div>
        <div class="col-5 bg-dark border" style="border: 5px solid darkblue; height: 300px; width: 600px;">
            <canvas id="grafico1"></canvas>
        </div>
        <div class="col-2 bg-dark border" style="border: 5px solid darkblue; height: 300px; width: 600px;"> 
        <br><br><br><br>
            1 es <strong>Peticion </strong><br>
            2 es <strong>Queja </strong><br>
            3 es <strong>Reclamo</strong> <br>
        </div>
    </div>
</div>
    <script>
        // Obtener el contexto del canvas
        var ctx = document.getElementById("grafico").getContext("2d");

        // Crear el gráfico con Chart.js
        var grafico = new Chart(ctx, {
            type: "line",
            data: <?php echo $datos_json; ?>
        });
        var ctx = document.getElementById("grafico1").getContext("2d");

        // Crear el gráfico con Chart.js
        var grafico = new Chart(ctx, {
            type: "bar",
            data: <?php echo $datos_json; ?>
        });
    </script>
    <?php
//otra forma de hacerlo
/*
    $sql1 = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");

    if(mysqli_num_rows($sql1) == 0){
        echo '<tr><td colspan="8">No hay datos.</td></tr>';
    }else{
        $no = 1;
        //aca mostramos los campos de la tabla a ver en el formulario 
        while($row = mysqli_fetch_assoc($sql1)){
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
                /*
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
                    <a href="edit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm " style="display: inline-block;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar Datos" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm" style="display: inline-block;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    <a href="profile.php?nik='.$row['codigo'].'" title="Ver Datos" class="btn btn-sucess btn-sm " style="display: inline-block;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
                </td>
            </tr>
            ';
            $fechas_legibles = array();
            foreach ($fechas as $row['Fecha_Creacion']) {
                $fechas_legibles[] = date("Y-m-d H:i:s", strtotime($fecha));
            }
            $no++;
        }
    }*/
    ?>

     
<br><br><br>
<center><p>&copy; Ricardo Arturo Torres Manrique <?php echo date("Y");?></p
		</center>



</body>
</html>