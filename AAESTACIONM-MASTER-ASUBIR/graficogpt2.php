<?php
require_once 'conexion/databaseAC.php';

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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Fecha</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Formulario HTML -->
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

    <div id="result"></div>
    <canvas id="myChart"></canvas>

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
</body>
</html>
