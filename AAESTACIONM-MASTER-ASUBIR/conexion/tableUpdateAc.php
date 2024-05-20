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
<?php
      include 'databaseAC.php';
      //trabajar con php
      $num = 0;
      $arrayfechaexactatotal = [];
      $arraydateFormat = [];
      $arraytemperaturate = [];
      $arrayhumedad = [];

      $pdo = Database::connect();

      $sql = 'SELECT * FROM esp32_01_tablerecord ORDER BY date DESC, time DESC';
      $fechaanterior = null;
      
      foreach ($pdo->query($sql) as $row) {
        $date = date_create($row['date']);
        $dateFormat = date_format($date, "d-m-Y");
        $data[] = ['date' => $dateFormat, 'tiempo' => $row['time'], 'temperature' => $row['temperature'], 'humidity' => $row['humidity'], 'veleta' => $row['veleta'], 'anemometro' => $row['anemometro'], 'pluviometro' => $row['pluviometro']];
        $longitudarray= count($data); 
        
        $num++;
        // echo '<tr>';
        // echo '<td>' . $num . '</td>';
        // echo '<td class="bdr">' . $row['temperature'] . ' °C</td>';
        // echo '<td class="bdr">' . $row['humidity'] . ' %</td>';
        // echo '<td class="bdr">' . $row['veleta'] . '</td>';
        // echo '<td class="bdr">' . $row['anemometro'] . ' km/h</td>';
        // echo '<td class="bdr">' . $row['pluviometro'] . ' ml/h</td>';
        // echo '<td class="bdr">' . $row['time'] . '</td>';
        // echo '<td>' . $dateFormat . '</td>';
        // echo '</tr>';
        // $arraytemperaturate[] = ['temperaturaa'=>$row['temperature']];
        $arreglofecha[] = ['date' => $dateFormat];
        //para sacar temperatura de fechas exactas hay que iterrar en el array
        //para sacar humedad de fechas exactas hay que iterrar en el arrayintentar hacerlo en el array data
      
        // print_r($data);
        // array_push($arrayfechaexactatotal,);
        array_push($arraydateFormat, $dateFormat);
      }
      //   $fechaexactacambia = $dateformat;
      //pasar todos array php a javascript json para el manejo de la logica y asyncs y traer las tablas sea lo esperado
      Database::disconnect();
      //funcion para promediar maximo y minimo de la temperatura en un solo dia
      $varprimerafecha = null;
      $arrayfechasphp = [];
      
      for ($i = 0; $i < $longitudarray; $i++) { 
          if ($data[$i]['date'] !== $varprimerafecha) {
              // Si la fecha actual es diferente a la fecha anterior, inicializar los arrays
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
      
              // Inicializar arrays temporales para almacenar los valores del día actual
              $temperaturas_del_dia = [];
              $humedad_del_dia = [];
              $veleta_del_dia = [];
              $anemometro_del_dia = [];
              $pluviometro_del_dia = [];
      
              // Recorrer $data para encontrar los registros del día actual
              foreach ($data as $registro) {
                  if ($registro['date'] === $data[$i]['date']) {
                      $temperaturas_del_dia[] = $registro['temperature'];
                      $humedad_del_dia[] = $registro['humidity'];
                      $veleta_del_dia[] = $registro['veleta'];
                      $anemometro_del_dia[] = $registro['anemometro'];
                      $pluviometro_del_dia[] = $registro['pluviometro'];
                  }
              }
      
              // Obtener los valores máximos y mínimos para cada tipo de dato del día actual
              $arrayfechasphp[$data[$i]['date']]['max_temp'] = max($temperaturas_del_dia);
              $arrayfechasphp[$data[$i]['date']]['min_temp'] = min($temperaturas_del_dia);
      
              $arrayfechasphp[$data[$i]['date']]['max_humidity'] = max($humedad_del_dia);
              $arrayfechasphp[$data[$i]['date']]['min_humidity'] = min($humedad_del_dia);
      
              // $arrayfechasphp[$data[$i]['date']]['max_veleta'] = max($veleta_del_dia);
              // $arrayfechasphp[$data[$i]['date']]['min_veleta'] = min($veleta_del_dia);
      
              $arrayfechasphp[$data[$i]['date']]['max_anemometro'] = max($anemometro_del_dia);
              $arrayfechasphp[$data[$i]['date']]['min_anemometro'] = min($anemometro_del_dia);
      
              $arrayfechasphp[$data[$i]['date']]['max_pluviometro'] = max($pluviometro_del_dia);
      
              // Actualizar $varprimerafecha
              $varprimerafecha = $data[$i]['date'];
          }
      }
      
      // Imprimir el array de manera ordenada
      foreach ($arrayfechasphp as $fecha => $datos) {
          echo "Fecha: $fecha\n <br>";
          echo "Temperatura Máxima: " . $datos['max_temp'] . "°C\n <br>";
          echo "Temperatura Mínima: " . $datos['min_temp'] . "°C\n <br>";
          echo "Humedad Máxima: " . $datos['max_humidity'] . "%\n <br>";
          echo "Humedad Mínima: " . $datos['min_humidity'] . "%\n <br>";
          echo "Veleta Máxima: " . $datos['max_veleta'] . "\n <br>";
          echo "Veleta Mínima: " . $datos['min_veleta'] . "\n <br>";
          echo "Anemómetro Máximo: " . $datos['max_anemometro'] . " km/h\n <br>";
          echo "Anemómetro Mínimo: " . $datos['min_anemometro'] . " km/h\n <br>";
          echo "Pluviómetro Máximo: " . $datos['max_pluviometro'] . " ml\n <br>";
          echo "-------------------------\n <br>";
      }
      
      ?>
</body>
</html>