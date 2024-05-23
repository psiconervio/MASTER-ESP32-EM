<?php
      include 'conexion/databaseAC.php';
      //trabajar con php
      $num = 0;
      $arrayfechaexactatotal = [];
      $arraydateFormat = [];
      $arraytemperaturate = [];
      $arrayhumedad = [];
      //The process for displaying a record table containing the DHT11 sensor data and the state of the LEDs.
      $pdo = Database::connect();
      // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_record'.
      // This table is used to store and record DHT11 sensor data updated by ESP32. 
      // This table is also used to store and record the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
      // To store data, this table is operated with the "INSERT" command, so this table will contain many rows.
      $sql = 'SELECT * FROM esp32_01_tablerecord ';
      $fechaanterior = null;
      /// ADAPTAR FRONT ENDDDDD
      foreach ($pdo->query($sql) as $row) {
       // $date = date_create($row['fecha']);
       // $dateFormat = date_format($date, "d-m-Y");
       $data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);}
        $datos[] = [ 'fecha' => $row['fecha'], 'max_temp' => $row['max_temp'],'min_temp' => $row['min_temp'], 'max_humidity' => $row['max_humidity'],'min_humidity' => $row['min_humidity'], 'moda_veleta' => $row['moda_veleta'], 'avg_anemometro' => $row['avg_anemometro'], 'sum_pluviometro' => $row['sum_pluviometro']];
        //print_r($data);
        
?>
<script> 
   // var data = <?php echo json_encode($data); ?>;
   // console.log(data);
</script>