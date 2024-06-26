<?php
include 'database.php'; // Incluye el archivo que contiene la configuración y funciones de la base de datos

function getStartAndEndDate($week, $year) {
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');
    return array($startDate, $endDate);
}

$pdo = Database::connect(); // Conecta a la base de datos

$sql = 'SELECT * FROM esp32_01_tableupdatedia ORDER BY fecha DESC';
$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); // Ejecuta la consulta y obtiene todos los registros como un array asociativo
Database::disconnect(); // Desconecta de la base de datos

$weeks = []; // Array para almacenar los datos agrupados por semanas

// Recorre cada registro de datos
foreach ($data as $row) {
    $date = new DateTime($row['fecha']); // Convierte la fecha de cada registro a un objeto DateTime
    $week = $date->format("W"); // Obtiene el número de semana del año de la fecha
    $year = $date->format("Y"); // Obtiene el año de la fecha
    $weekKey = $year . '-W' . $week; // Crea una clave única para la semana en el formato 'YYYY-WW'

    // Si no existe una entrada para la semana en el array $weeks, la inicializa
    if (!isset($weeks[$weekKey])) {
        $weeks[$weekKey] = [
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

    // Agrega los datos del registro actual a la semana correspondiente
    $weeks[$weekKey]['fechas'][] = $row['fecha'];
    $weeks[$weekKey]['max_temp'][] = $row['max_temp'];
    $weeks[$weekKey]['min_temp'][] = $row['min_temp'];
    $weeks[$weekKey]['max_humidity'][] = $row['max_humidity'];
    $weeks[$weekKey]['min_humidity'][] = $row['min_humidity'];
    $weeks[$weekKey]['moda_veleta'][] = $row['moda_veleta'];
    $weeks[$weekKey]['avg_anemometro'][] = $row['avg_anemometro'];
    $weeks[$weekKey]['sum_pluviometro'] += $row['sum_pluviometro'];
}

// Función para calcular la moda de un array de valores
function calcularModa($valores) {
    $frecuencias = array_count_values($valores); // Cuenta la frecuencia de cada valor en el array
    arsort($frecuencias); // Ordena los valores por frecuencia en orden descendente
    $moda = array_key_first($frecuencias); // Obtiene el valor con mayor frecuencia (la moda)
    return $moda; // Retorna la moda
}

$pdo = Database::connect(); // Conecta a la base de datos

// Recorre cada semana en el array $weeks
foreach ($weeks as $weekKey => $values) {
    // Obtiene la fecha de inicio y fin de la semana
    list($startDate, $endDate) = getStartAndEndDate(explode('-W', $weekKey)[1], explode('-W', $weekKey)[0]);

    // Verifica si ya existe una entrada para la semana
    $sqlCheck = "SELECT COUNT(*) FROM esp32_01_tableupdatedia_semanal WHERE semana = ?";
    $stmt = $pdo->prepare($sqlCheck);
    $stmt->execute([$weekKey]);
    $rowCount = $stmt->fetchColumn();

    if ($rowCount == 0) {
        // Calcula los valores estadísticos para la semana
        $max_temp = max($values['max_temp']); // Temperatura máxima
        $min_temp = min($values['min_temp']); // Temperatura mínima
        $max_humidity = max($values['max_humidity']); // Humedad máxima
        $min_humidity = min($values['min_humidity']); // Humedad mínima
        $moda_veleta = calcularModa($values['moda_veleta']); // Moda de la veleta (dirección del viento más frecuente)
        $avg_anemometro = round(array_sum($values['avg_anemometro']) / count($values['avg_anemometro']), 2); // Promedio del anemómetro (velocidad del viento)
        $sum_pluviometro = $values['sum_pluviometro']; // Suma del pluviómetro (cantidad de lluvia)

        // Inserta los datos calculados en la tabla semanal
        $sqlInsert = "INSERT INTO esp32_01_tableupdatedia_semanal (semana, start_date, end_date, max_temp, min_temp, max_humidity, min_humidity, moda_veleta, avg_anemometro, sum_pluviometro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->execute([$weekKey, $startDate, $endDate, $max_temp, $min_temp, $max_humidity, $min_humidity, $moda_veleta, $avg_anemometro, $sum_pluviometro]);
       

    }

}

Database::disconnect(); // Desconecta de la base de datos
        // // Imprime por pantalla la información ingresada
        // echo "Semana: $weekKey<br>";
        // echo "Fecha de inicio: $startDate<br>";
        // echo "Fecha de fin: $endDate<br>";
        // echo "Max Temp: $max_temp<br>";
        // echo "Min Temp: $min_temp<br>";
        // echo "Max Humidity: $max_humidity<br>";
        // echo "Min Humidity: $min_humidity<br>";
        // echo "Moda Veleta: $moda_veleta<br>";
        // echo "Avg Anemometro: $avg_anemometro<br>";
        // echo "Sum Pluviometro: $sum_pluviometro<br><br>";
?>