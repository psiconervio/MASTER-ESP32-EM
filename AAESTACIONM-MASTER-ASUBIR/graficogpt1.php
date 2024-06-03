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
                        echo "<br> ID: " . $row["max_temp"] . " - Fecha: " . $row["fecha"] . "<br>";
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
            <option value="temperatura">Temperatura</option>
            <option value="humedad">Humedad</option>
            <option value="veleta">Veleta</option>
            <option value="velocidadviento">Velocidad del viento</option>
            <option value="pluviometro">Pluviómetro</option>
        </select><br>
        <button type="submit">Enviar</button>
    </form>

    <div id="result"></div>
    <canvas id="myChart"></canvas>

    <script>
        var data = <?php echo json_encode($data); ?>;
        console.log(data);

        var fechasgrafico = [];
        var maxTempValues = [];
        var minTempValues = [];
        var maxhumValues = [];
        var minhumValues = [];
        var sumpluviValues = [];
        var modaveletaValues = [];
        var avganemometroValues = [];

        function showMaxTempValues() {
            fechasgrafico = data.map(item => item.fecha);
            maxTempValues = data.map(item => item.max_temp);
            minTempValues = data.map(item => item.min_temp);
            maxhumValues = data.map(item => item.max_humidity);
            minhumValues = data.map(item => item.min_humidity);
            sumpluviValues = data.map(item => item.sum_pluviometro);
            modaveletaValues = data.map(item => item.moda_veleta);
            avganemometroValues = data.map(item => item.avg_anemometro);
            console.log(fechasgrafico);
            console.log(maxTempValues);
            console.log(minTempValues);
            console.log(maxhumValues);
            console.log(minhumValues);
            console.log(sumpluviValues);
            console.log(modaveletaValues);
            console.log(avganemometroValues);
        }

        window.onload = function() {
            if (data.length > 0) {
                showMaxTempValues();
                renderChart();
            }
        };

        function renderChart() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: fechasgrafico,
                    datasets: [{
                        label: 'Temperatura Máxima',
                        data: maxTempValues,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        fill: false
                    }, {
                        label: 'Humedad Máxima',
                        data: maxhumValues,
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
        }
    </script>
</body>
</html>
