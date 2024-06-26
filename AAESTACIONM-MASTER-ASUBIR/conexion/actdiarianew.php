<?php
include 'database.php';

try {
    $pdo = Database::connect();

    $sql = 'SELECT * FROM esp32_01_tablerecord ORDER BY date DESC, time DESC';
    $data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    Database::disconnect();

    $num = count($data);
    $arrayfechasphp = [];

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

    // Función para calcular la moda
    function calcularModa($valores) {
        $frecuencias = array_count_values($valores); // Cuenta la frecuencia de cada valor
        arsort($frecuencias); // Ordena los valores por frecuencia en orden descendente
        $moda = array_key_first($frecuencias); // Obtiene el valor con mayor frecuencia
        return $moda;
    }

    $pdo = Database::connect();
    foreach ($arrayfechasphp as $date => $values) {
        $max_temp = max($values['temperaturas']);
        $min_temp = min($values['temperaturas']);
        $max_humidity = max($values['humedades']);
        $min_humidity = min($values['humedades']);
        $moda_veleta = calcularModa($values['veletas']);
        $max_anemometro = max($values['anemometros']);
        $min_anemometro = min($values['anemometros']);
        $avg_anemometro = array_sum($values['anemometros']) / count($values['anemometros']);
        $rounded_avg_anemometro = round($avg_anemometro, 2);
        $sum_pluviometro = array_sum($values['pluviometros']);

        $formatted_date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        // Verifica si ya existe una entrada para la fecha formateada
        $sqlCheck = "SELECT COUNT(*) FROM esp32_01_tableupdatedia WHERE fecha = ?";
        $stmt = $pdo->prepare($sqlCheck);
        $stmt->execute([$formatted_date]);
        $rowCount = $stmt->fetchColumn();

        if ($rowCount == 0) {
            // Inserta los datos si no existe una entrada para la fecha
            $sqlInsert = "INSERT INTO esp32_01_tableupdatedia (fecha, max_temp, min_temp, max_humidity, min_humidity, moda_veleta, avg_anemometro, sum_pluviometro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sqlInsert);
            $stmt->execute([$formatted_date, $max_temp, $min_temp, $max_humidity, $min_humidity, $moda_veleta, $rounded_avg_anemometro, $sum_pluviometro]);
        }
    }

    Database::disconnect();

    echo "actualizacion diaria completada con exito.";
} catch (Exception $e) {
    // Manejo de errores
    echo "Ocurrió un error: " . $e->getMessage();
}
?>
