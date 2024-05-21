<?php
include 'databaseAC.php';

$pdo = Database::connect();

// Obtener todos los registros y almacenarlos en una variable
$sql = 'SELECT * FROM esp32_01_tablerecord ORDER BY date DESC, time DESC';
$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
Database::disconnect();

$num = count($data);
$arrayfechasphp = [];

// Transformar y agrupar datos por fecha
foreach ($data as $row) {
    $date = date_create($row['date']);
    $dateFormat = date_format($date, "d-m-Y");

    if (!isset($arrayfechasphp[$dateFormat])) {
        $arrayfechasphp[$dateFormat] = [
            'temperaturas' => [],
            'humedades' => [],
            'veletas' => [],
            'anemometros' => [],
            'pluviometros' => []
        ];
    }

    $arrayfechasphp[$dateFormat]['temperaturas'][] = $row['temperature'];
    $arrayfechasphp[$dateFormat]['humedades'][] = $row['humidity'];
    $arrayfechasphp[$dateFormat]['veletas'][] = $row['veleta'];
    $arrayfechasphp[$dateFormat]['anemometros'][] = $row['anemometro'];
    $arrayfechasphp[$dateFormat]['pluviometros'][] = $row['pluviometro'];
}

// Calcular máximos, mínimos y otros valores necesarios por fecha
$pdo = Database::connect();
foreach ($arrayfechasphp as $date => $values) {
    $max_temp = max($values['temperaturas']);
    $min_temp = min($values['temperaturas']);
    $max_humidity = max($values['humedades']);
    $min_humidity = min($values['humedades']);
    $max_veleta = max($values['veletas']);
    $min_veleta = min($values['veletas']);
    $max_anemometro = max($values['anemometros']);
    $min_anemometro = min($values['anemometros']);
    $avg_anemometro = array_sum($values['anemometros']) / count($values['anemometros']);
    $rounded_avg_anemometro = round($avg_anemometro, 2);
    $max_pluviometro = max($values['pluviometros']);
    $min_pluviometro = min($values['pluviometros']);
    $sum_pluviometro = array_sum($values['pluviometros']);

    $formatted_date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');

    echo "Fecha: $date\n <br>";
    echo "Max Temp: $max_temp\n <br>";
    echo "Min Temp: $min_temp\n <br>";
    echo "Max Humidity: $max_humidity\n <br>";
    echo "Min Humidity: $min_humidity\n <br>";
    echo "Max Veleta: $max_veleta\n <br>";
    echo "Avg Anemometro: $rounded_avg_anemometro\n <br>";
    echo "Max Pluviometro: $max_pluviometro\n <br>";
    echo "Sum Pluviometro: $sum_pluviometro\n <br>";
    echo "Fecha Formateada: $formatted_date\n <br><br>";

    // Verificar si el registro ya existe
    $sqlCheck = "SELECT COUNT(*) FROM esp32_01_tableupdatedia WHERE fecha = ?";
    $qCheck = $pdo->prepare($sqlCheck);
    $qCheck->execute([$formatted_date]);
    $count = $qCheck->fetchColumn();

    if ($count == 0) {
        // Insertar solo si el registro no existe
        $sqlInsert = "INSERT INTO esp32_01_tableupdatedia (fecha, max_temp, min_temp, max_humidity, min_humidity, max_veleta, avg_anemometro, max_pluviometro, sum_pluviometro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->execute([$formatted_date, $max_temp, $min_temp, $max_humidity, $min_humidity, $max_veleta, $rounded_avg_anemometro, $max_pluviometro, $sum_pluviometro]);
    }
}

Database::disconnect();
?>