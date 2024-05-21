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
            // Inicializar los arrays de la fecha actual
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
    
            // Obtener los valores máximos y mínimos para cada tipo de dato del día actual y asignarlos a variables
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
    
            // Asignar los valores al array usando las variables
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
            $fechaaa = DateTime::createFromFormat('d-m-Y', $data[$i]['date']);
            $fechaaa = $date->format('Y-m-d');
            //$fechaexacta = $data[$i]['date'];

    
            // Imprimir los valores
            echo "Fecha: " . $data[$i]['date'] . "\n <br>";
            echo "registros: " . $longitudarray . "\n <br>";
            echo "Max Temp: " . $max_temp . "\n <br>";
            echo "Min Temp: " . $min_temp . "\n <br>";
            echo "Max Humidity: " . $max_humidity . "\n <br>";
            echo "Min Humidity: " . $min_humidity . "\n <br>";
            echo "moda Veleta: " . $max_veleta . "\n <br>";
            echo "promedio Anemometro: " . $max_anemometro . "\n <br>";
            echo "sumatoria Pluviometro: " . $max_pluviometro . "\n <br>";
            echo "fecha: " . $fechaaa . "\n <br><br>";
            echo "\n";
            

                //que se ejecute a una hora determinadad  
        $pdo = Database::connect();
        //::: The process of entering data into a table.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO esp32_01_tableupdatedia (tempmax,tempmin,hummax,hummin,veleta,anemometro,pluviometro,fecha) values(?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($max_temp,$min_temp,$max_humidity,$min_humidity,$max_veleta,$max_anemometro,$max_pluviometro,$fechaaa));  
        //::::::::
        Database::disconnect();
            // Actualizar $varprimerafecha
            $varprimerafecha = $data[$i]['date'];
        }
    }

      ?>
</body>
</html>