<?php
include 'database.php'; // Incluye el archivo que contiene la configuración y funciones de la base de datos

$pdo = Database::connect(); // Conecta a la base de datos

// Consulta para obtener todos los registros de la tabla 'esp32_01_tableupdatedia' ordenados por fecha descendente
$sql = 'SELECT * FROM esp32_01_tableupdatedia ORDER BY fecha DESC';
$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); // Ejecuta la consulta y obtiene todos los registros como un array asociativo
Database::disconnect(); // Desconecta de la base de datos

$months = []; // Array para almacenar los datos agrupados por meses

// Recorre cada registro de datos
foreach ($data as $row) {
    $date = new DateTime($row['fecha']); // Convierte la fecha de cada registro a un objeto DateTime
    $month = $date->format("Y-m"); // Obtiene el año y mes de la fecha en formato 'YYYY-MM'

    // Si no existe una entrada para el mes en el array $months, la inicializa
    if (!isset($months[$month])) {
        $months[$month] = [
            'fechas' => [],
            'max_temp' => [],
            'min_temp' => [],
            'max_humidity' => [],
            'min_humidity' => [],
            'moda_veleta' => [],
            'avg_anemometro' => [],
            'sum_pluviometro' => 0
        ];
    }

    // Agrega los datos del registro actual al mes correspondiente
    $months[$month]['fechas'][] = $row['fecha'];
    $months[$month]['max_temp'][] = $row['max_temp'];
    $months[$month]['min_temp'][] = $row['min_temp'];
    $months[$month]['max_humidity'][] = $row['max_humidity'];
    $months[$month]['min_humidity'][] = $row['min_humidity'];
    $months[$month]['moda_veleta'][] = $row['moda_veleta'];
    $months[$month]['avg_anemometro'][] = $row['avg_anemometro'];
    $months[$month]['sum_pluviometro'] += $row['sum_pluviometro'];
}

// Función para calcular la moda de un array de valores
function calcularModa($valores) {
    $frecuencias = array_count_values($valores); // Cuenta la frecuencia de cada valor en el array
    arsort($frecuencias); // Ordena los valores por frecuencia en orden descendente
    $moda = array_key_first($frecuencias); // Obtiene el valor con mayor frecuencia (la moda)
    return $moda; // Retorna la moda
}

$pdo = Database::connect(); // Conecta a la base de datos

// Recorre cada mes en el array $months
foreach ($months as $month => $values) {
    // Verifica si ya existe una entrada para el mes
    $sqlCheck = "SELECT COUNT(*) FROM esp32_01_tableupdatedia_mensual WHERE mes = ?";
    $stmt = $pdo->prepare($sqlCheck);
    $stmt->execute([$month]);
    $rowCount = $stmt->fetchColumn();

    if ($rowCount == 0) {
        // Calcula los promedios y otros valores estadísticos para el mes
        $avg_max_temp = round(array_sum($values['max_temp']) / count($values['max_temp']), 2); // Promedio de temperatura máxima
        $avg_min_temp = round(array_sum($values['min_temp']) / count($values['min_temp']), 2); // Promedio de temperatura mínima
        $avg_max_humidity = round(array_sum($values['max_humidity']) / count($values['max_humidity']), 2); // Promedio de humedad máxima
        $avg_min_humidity = round(array_sum($values['min_humidity']) / count($values['min_humidity']), 2); // Promedio de humedad mínima
        $moda_veleta = calcularModa($values['moda_veleta']); // Moda de la veleta (dirección del viento más frecuente)
        $avg_anemometro = round(array_sum($values['avg_anemometro']) / count($values['avg_anemometro']), 2); // Promedio del anemómetro (velocidad del viento)
        $sum_pluviometro = $values['sum_pluviometro']; // Suma del pluviómetro (cantidad de lluvia)

        // Inserta los datos calculados en la tabla mensual
        $sqlInsert = "INSERT INTO esp32_01_tableupdatedia_mensual (mes, avg_max_temp, avg_min_temp, avg_max_humidity, avg_min_humidity, moda_veleta, avg_anemometro, sum_pluviometro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->execute([$month, $avg_max_temp, $avg_min_temp, $avg_max_humidity, $avg_min_humidity, $moda_veleta, $avg_anemometro, $sum_pluviometro]);
        

    }


}

Database::disconnect(); // Desconecta de la base de datos
// echo "Datos mensual <br>"; 
// echo "Max Temp: $avg_max_temp\n <br>";
// echo "Min Temp: $avg_min_temp\n <br>";
// echo "Max Humidity: $avg_max_humidity\n <br>";
// echo "Min Humidity: $avg_min_humidity\n <br>";
// echo "Moda Veleta: $moda_veleta\n <br>";
// echo "Avg Anemometro: $avg_anemometro\n <br>";
// echo "Sum Pluviometro: $sum_pluviometro\n <br>";
// echo "Fecha Formateada: $formatted_date\n <br><br>";
?>
