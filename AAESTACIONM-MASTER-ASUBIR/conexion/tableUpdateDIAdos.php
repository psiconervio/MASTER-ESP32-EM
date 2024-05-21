<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" ">
  <h1>LOQUE SE VA A VER EN LA ESRTACION/DIA</h1>
  <?php include 'databaseAC.php';
  $num = 0;
  $data = [];
  $arraydateFormat = [];

  $pdo = Database::connect();
  $sql = 'SELECT * FROM esp32_01_tablerecord ORDER BY date DESC, time DESC';
  $fechaanterior = null;
 //se llena data con toda la tabla 
  foreach ($pdo->query($sql) as $row) {
    $date = date_create($row['date']);
    $dateFormat = date_format($date, "d-m-Y");
    $data[] = [
      'date' => $dateFormat,
      'tiempo' => $row['time'],
      'temperature' => $row['temperature'],
      'humidity' => $row['humidity'],
      'veleta' => $row['veleta'],
      'anemometro' => $row['anemometro'],
      'pluviometro' => $row['pluviometro']
    ];
    $num++;
    array_push($arraydateFormat, $dateFormat);
  }
  Database::disconnect();

  $varprimerafecha = null;
  $arrayfechasphp = [];
  $pdo = Database::connect(); // Open the connection once
  
  for ($i = 0; $i < count($data); $i++) {
    if ($data[$i]['date'] !== $varprimerafecha) {
      $arrayfechasphp[$data[$i]['date']] = [
        'max_temp' => null,
        'min_temp' => null,
        'max_humidity' => null,
        'min_humidity' => null,
        'max_veleta' => null,
        'min_veleta' => null,
        'max_anemometro' => null,
        'min_anemometro' => null,
        'max_pluviometro' => null,
        'min_pluviometro' => null,
      ];
      
      $temperaturas_del_dia = [];
      $humedad_del_dia = [];
      $veleta_del_dia = [];
      $anemometro_del_dia = [];
      $pluviometro_del_dia = [];

      foreach ($data as $registro) {
        if ($registro['date'] === $data[$i]['date']) {
          $temperaturas_del_dia[] = $registro['temperature'];
          $humedad_del_dia[] = $registro['humidity'];
          $veleta_del_dia[] = $registro['veleta'];
          $anemometro_del_dia[] = $registro['anemometro'];
          $pluviometro_del_dia[] = $registro['pluviometro'];
        }
      }

      $max_temp = max($temperaturas_del_dia);
      $min_temp = min($temperaturas_del_dia);
      $max_humidity = max($humedad_del_dia);
      $min_humidity = min($humedad_del_dia);
      $max_veleta = max($veleta_del_dia);
      $min_veleta = min($veleta_del_dia);
      $max_anemometro = max($anemometro_del_dia);
      $min_anemometro = min($anemometro_del_dia);
      $max_pluviometro = max($pluviometro_del_dia);
      $min_pluviometro = min($pluviometro_del_dia);

      $arrayfechasphp[$data[$i]['date']]['max_temp'] = $max_temp;
      $arrayfechasphp[$data[$i]['date']]['min_temp'] = $min_temp;
      $arrayfechasphp[$data[$i]['date']]['max_humidity'] = $max_humidity;
      $arrayfechasphp[$data[$i]['date']]['min_humidity'] = $min_humidity;
      $arrayfechasphp[$data[$i]['date']]['max_veleta'] = $max_veleta;
      $arrayfechasphp[$data[$i]['date']]['min_veleta'] = $min_veleta;
      $arrayfechasphp[$data[$i]['date']]['max_anemometro'] = $max_anemometro;
      $arrayfechasphp[$data[$i]['date']]['min_anemometro'] = $min_anemometro;
      $arrayfechasphp[$data[$i]['date']]['max_pluviometro'] = $max_pluviometro;
      $arrayfechasphp[$data[$i]['date']]['min_pluviometro'] = $min_pluviometro;
      $fechaaa = DateTime::createFromFormat('d-m-Y', $data[$i]['date'])->format('Y-m-d');

      echo "Fecha: " . $data[$i]['date'] . "\n <br>";
      echo "registros: " . count($data) . "\n <br>";
      echo "Max Temp: " . $max_temp . "\n <br>";
      echo "Min Temp: " . $min_temp . "\n <br>";
      echo "Max Humidity: " . $max_humidity . "\n <br>";
      echo "Min Humidity: " . $min_humidity . "\n <br>";
      echo "moda Veleta: " . $max_veleta . "\n <br>";
      echo "promedio Anemometro: " . $max_anemometro . "\n <br>";
      echo "sumatoria Pluviometro: " . $max_pluviometro . "\n <br>";
      echo "fecha: " . $fechaaa . "\n <br><br>";
      echo "\n";

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO esp32_01_tableupdatedia (tempmax, tempmin, hummax, hummin, veleta, anemometro, pluviometro, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($max_temp, $min_temp, $max_humidity, $min_humidity, $max_veleta, $max_anemometro, $max_pluviometro, $fechaaa));

      $varprimerafecha = $data[$i]['date'];
    }
  }

  Database::disconnect(); // Close the connection once
  ?>

</body>

</html>