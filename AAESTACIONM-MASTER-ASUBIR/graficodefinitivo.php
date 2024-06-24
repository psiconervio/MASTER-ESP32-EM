<?php
require_once 'conexion/database.php';

$data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $item = $_POST["items"];

    if (!empty($fecha)) {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            try {
                $pdo = Database::connect();
                $sql = "SELECT * FROM esp32_01_tableupdatedia WHERE fecha >= DATE_SUB(:fecha, INTERVAL 7 DAY) LIMIT 7";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<br> - Fecha: " . $row["fecha"] ."";
                        $data[] = $row;
                    }
                } else {
                    echo "No se encontraron registros";
                }

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
}
?>

<!DOCTYPE html>
<html lang="es">
<head> <style>
      body {
        margin: 0; /* Elimina márgenes por defecto del body */
      }

      .navbar {
        display: flex;
        justify-content: center;
        overflow: hidden;
        background-color: #333;
        position: fixed;
        bottom: 0;
        width: 100%;
        align-items: center;
        padding: 0;
        margin: 0;
        border-radius: 12px;
      }

      .navbar a {
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
      }

      .navbar a:hover {
        background: #ddd;
        color: black;
      }

      @media (max-width: 700px) {
        .navbar a {
          font-size: 20px;
        }
      }
    </style></script>
    <script src="resources/fontasome.js"></script>
    <script src="https://kit.fontawesome.com/da4a5b6f37.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="resources/fontasome.js"></script>

    <title>Formulario de Fecha</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="navbar.css">
</head>
<header>
    <h1>Selecciona tu fecha</h1>
</header>
<body style="">
    <br>
    <!-- Formulario HTML -->
    <div class="divform">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="fecha">Selecciona una fecha:</label>
        <input type="date" name="fecha" id="fecha"><br>
        <label for="items">Seleccione un sensor:</label>
        <select name="items" id="items">
            <option value="max_temp">Temperatura Máxima</option>
            <option value="min_temp">Temperatura Mínima</option>
            <option value="max_humidity">Humedad Máxima</option>
            <option value="min_humidity">Humedad Mínima</option>
            <option value="moda_veleta">Veleta</option>
            <option value="avg_anemometro">Velocidad del Viento</option>
            <option value="sum_pluviometro">Pluviómetro</option>
        </select><br>
        <button type="submit">Enviar</button>
    </form>
    </div>

    <div id="result"></div>
    <canvas id="myChart"></canvas>
    <!-- <style>
        .divform {
            display: grid;
            justify-items:center; 
            aling-items: center;
        }
        
    </style> -->
    <script>
        var data = <?php echo json_encode($data); ?>;
        console.log(data);

        var fechasgrafico = data.map(item => item.fecha);

        function updateChart(selectedField) {
            var selectedData = data.map(item => item[selectedField]);

            myChart.data.labels = fechasgrafico;
            myChart.data.datasets[0].data = selectedData;
            myChart.data.datasets[0].label = document.querySelector(`#items option[value="${selectedField}"]`).innerText;

            myChart.update();
        }

        document.getElementById('items').addEventListener('change', function() {
            var selectedValue = this.value;
            updateChart(selectedValue);
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: fechasgrafico,
                datasets: [{
                    label: 'Sensor Seleccionado',
                    data: data.map(item => item.max_temp),
                    backgroundColor:"rgba(255, 99, 132)",
                    borderColor: "rgb(255, 99, 132)",
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

        window.onload = function() {
            if (data.length > 0) {
                updateChart('max_temp');  // Por defecto, mostrar Temperatura Máxima
            }
        };
    </script>
        <div class="navbar">
      <i class="fa-solid fa-house-chimney"></i>
      <a href="#home">Inicio</a>
      <i class="fa-solid fa-chart-line"></i>
      <a href="#home">Grafico</a>
      <i class="fa-solid fa-chart-simple"></i>
      <a href="#news">Maximo</a>
      <a href="#historico">Historico</a>
      <i class="fa-solid fa-map"></i>
      <a href="#mapa">Mapa</a>
      <i class="fa-solid fa-bars"></i>
      <a href="#mas">Mas</a>
    </div>
</body>
<footer>
<div class="navbar">
  <a href="index.php">
    <i class="fa-solid fa-house-chimney"></i>
    <span>Inicio</span>
  </a>
  <a href="recordtable.php">
    <i class="fa-solid fa-chart-line"></i>
    <span>Grafico</span>
  </a>
  <a href="graficodefinitivo.php">
    <i class="fa-solid fa-chart-simple"></i>
    <span>Maximo</span>
  </a>
  <a href="graficodefinitivo.php">
    <i class="fa-solid fa-book-open"></i>
    <span>Historico</span>
  </a>
  <a href="#mapa">
    <i class="fa-solid fa-map"></i>
    <span>Mapa</span>
  </a>

</div>
</footer>
</html>