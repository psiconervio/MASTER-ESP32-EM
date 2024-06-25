<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Fecha</title>
</head>
<body>
    <!-- Formulario HTML -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="fecha">Selecciona una fecha:</label>
    <input type="date" name="fecha" id="fecha"><br>
    <label for="items">seleccione un sensor:</label>
    <select name="items" id="items">
      <option value="temperatura">Temperatura</option>
      <option value="humedad">humedad</option>
      <option value="veleta">veleta</option>
      <option value="velocidadviento">velocidadviento</option>
      <option value="pluviometro">pluviometro</option>
    <!-- HACER FUNCION EN BOTON SUBMIT QUE LE PASE LOS ARRAY AL GRAFICO -->
  </select><br>
        <button type="submit" onclick="submitForm()">Enviar</button>
    </form>
    <script>
        function submitForm() {
            // Obtener el elemento select
            var selectElement = document.getElementById('items');
            // Obtener el valor seleccionado
            var selectedValue = selectElement.value;
            // Hacer algo con el valor seleccionado (ejemplo: mostrar en consola)
            // Obtener los valores del campo seleccionado
            var selectedData = data.map(item => item[selectedValue]);
            console.log('Valor seleccionado:', selectedValue);
            // Puedes pasar el valor seleccionado a una función que actualice el gráfico
            // updateGraph(selectedValue);
        }
        // Opcional: detectar cambios en la selección y realizar una acción
        document.getElementById('items').addEventListener('change', function() {
            var selectedValue = this.value;
            console.log('Valor cambiado a:', selectedValue);
        });
    </script>
<?php
    require_once 'conexion/database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $item = $_POST["items"];
    print_r($fecha);
    print_r($item);
    $data =[];
    $datatemperatura= [];
//este codigo funciona optimo si es que estan todas las fechas, funcionara mal  o traera otros registros si faltan fechas
    if (!empty($fecha)) {
        // Validar formato de fecha (por ejemplo, YYYY-MM-DD)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            try {
                // Conectar a la base de datos usando la clase Database
                $pdo = Database::connect();
                // Preparar la consulta SQL con un marcador de posición
                $sql = "SELECT * FROM esp32_01_tableupdatedia WHERE fecha >= DATE_SUB(:fecha, INTERVAL 7 DAY) LIMIT 7";
                $stmt = $pdo->prepare($sql);
                // Enlazar la variable $fecha al marcador de posición
                $stmt->bindParam(':fecha', $fecha);
                // Ejecutar la consulta
                $stmt->execute();
                // Obtener los resultados
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Procesar los resultados

                if ($stmt->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<br> ID: " . $row["max_temp"] . " - Fecha: " . $row["fecha"] . "<br>";
                        $datatemperatura[] =   $row['max_temp'];
                        $datatemperatura[] =   $row['max_temp'];
                        $data[] =$row;
                    }
                } else {
                    echo "No se encontraron registros";
                }

                // Desconectar de la base de datos
                Database::disconnect();
            } catch (PDOException $e) {
                echo "Error de consulta: " . $e->getMessage();
            }
        } else {
            echo "Formato de fecha inválido. Use YYYY-MM-DD.";
        }
    } else {
        echo "La fecha no puede estar vacía";
    }
    print_r($data);
}
?>
<script>
    var data = <?php echo json_encode($data); ?>;
    console.log(data);
    function showMaxTempValues() {
            var fechasgrafico = data.map(item => item.fecha);
            var maxTempValues = data.map(item => item.max_temp);
            var minTempValues = data.map(item => item.min_temp);
            var maxhumValues = data.map(item => item.max_humidity);
            var minhumValues = data.map(item => item.max_humidity);
            var sumpluviValues = data.map(item => item.sum_pluviometro);
            var modaveletaValues = data.map(item => item.moda_veleta);
            var avganemometroValues = data.map(item => item.avg_anemometro);
            console.log(fechasgrafico);
            console.log(maxTempValues);
            console.log(minTempValues);
            console.log(maxhumValues);
            console.log(minhumValues);
            console.log(sumpluviValues);
            console.log(modaveletaValues);
            console.log(avganemometroValues);

        }
//    showMaxTempValues();
   // window.onload = showMaxTempValues;

   // console.log(maxTempValues);
           // Ejecutar la función cuando la página se haya cargado completamente
           window.onload = function() {
            if (data.length > 0) {
                showMaxTempValues();
            }
        };

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: fechasgrafico,
        datasets: [{
          label: 'Temperatura',
          data: maxTempValues,
          borderColor: 'rgba(255, 99, 132, 1)',
          fill: false
        }, {
          label: 'Humedad',
          data: max_humidity,
          borderColor: 'rgba(75, 192, 192, 1)',
          fill: false
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    if (myChart) {
      myChart.update();
    }
    // function showMaxTempValues() {
    //         var maxTempValues = data.map(item => item.max_temp);
    //         console.log(maxTempValues);
    //         var resultDiv = document.getElementById('result');
    //         resultDiv.innerHTML = "<h3>Valores de Temperatura Máxima:</h3>" + maxTempValues.join(', ');
    //     }
    // console.log(maxTempValues);
    showMaxTempValues();
   // window.onload = showMaxTempValues;

    //console.log(arrayfechaexactatotal);
           // Ejecutar la función cuando la página se haya cargado completamente
           window.onload = function() {
            if (data.length > 0) {
                showMaxTempValues();
            }
        };
  </script>
<div id="result" class="result"></div>

</body>
</html>
