// recordtable.php
<!DOCTYPE HTML>
<html>
<head>
  <title>Datos Estacion Metereologica del Nodo Tecnologico</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="resources/stylerecord.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div class="topnav">
    <h3>LABORATORIO DE INNOVACION</h3>
  </div>
  <br>
  <h3 style="color: #0c6980;">DATOS ESTACION METEREOLOGICA</h3>
  <table class="styled-table" id="table_id">
    <thead>
      <tr>
        <th>NO</th>
        <th>TEMPERATURA MAX °C</th>
        <th>TEMPERATURA MIN °C</th>
        <th>HUMEDAD (%)</th>
        <th>VELOCIDAD DE VIENTO</th>
        <th>CAUDAL DE LLUVIA</th>
        <th>DIRECCION DE VIENTO</th>
        <th>FECHA (D-M-A)</th>
        
      </tr>
    </thead>
    <tbody id="tbody_table_record">
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
      $sql = 'SELECT * FROM esp32_01_tableupdatedia ORDER BY fecha';
      $fechaanterior = null;
      /// ADAPTAR FRONT ENDDDDD
      foreach ($pdo->query($sql) as $row) {
        $date = date_create($row['fecha']);
        $dateFormat = date_format($date, "d-m-Y");
       $data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $data[] = [ 'fecha' => $row['fecha'], 'max_temp' => $row['max_temp'],'min_temp' => $row['min_temp'], 'max_humidity' => $row['max_humidity'],'min_humidity' => $row['min_humidity'], 'moda_veleta' => $row['moda_veleta'], 'avg_anemometro' => $row['avg_anemometro'], 'sum_pluviometro' => $row['sum_pluviometro']];
      //  $longitudarray= count($data); 
      //print_r($data);  
        $num++;
        echo '<tr>';
        echo '<td>' . $num . '</td>';
        echo '<td class="bdr">' . $row['max_temp'] . ' °C</td>';
        echo '<td class="bdr">' . $row['min_temp'] . ' %</td>';
        echo '<td class="bdr">' . $row['max_humidity'] . '</td>';
        echo '<td class="bdr">' . $row['avg_anemometro'] . ' km/h</td>';
        echo '<td class="bdr">' . $row['sum_pluviometro'] . ' ml/h</td>';
        echo '<td class="bdr">' . $row['moda_veleta'] . '</td>';
        echo '<td>' . $row['fecha'] . '</td>';
        echo '</tr>';
        // $arraytemperaturate[] = ['temperaturaa'=>$row['temperature']];
       // $arreglofecha[] = ['fecha' => $row['fecha']];
        print_r($data);
        //para sacar temperatura de fechas exactas hay que iterrar en el array
        //para sacar humedad de fechas exactas hay que iterrar en el arrayintentar hacerlo en el array data
      

        // print_r($row);
        // array_push($arrayfechaexactatotal,);
        //array_push($arraydateFormat, $dateFormat);
      }
      
      //   $fechaexactacambia = $dateformat;
      //pasar todos array php a javascript json para el manejo de la logica y asyncs y traer las tablas sea lo esperado
      Database::disconnect();
  
      ?>
      <script>
        let fechas = [];
        let fechaanterior ;
        var data = <?php echo json_encode($data); ?>;
        console.log(data);
        function fechaa() {
          for (let i = 0; i <= 15; i++) {

            if (data[i].date !== fechaanterior) {
              fechas.push(data[i].date);
              fechaanterior = data[i].date;

            }
          }
          console.log(fechas);

          //  hacer una sola funcion para que se ejecute cuando se aprieta el boton
        }
        fechaa()
        //  let fechas = data;
        // let temperaturadata = data.temperature;

        var arreglofechas = <?php echo json_encode($arreglofecha); ?>;
      </script>
    </tbody>
  </table>
  <br>
  <div class="btn-group">
    <button class="button" id="btn_prev" onclick="prevPage()">Anterior</button>
    <button class="button" id="btn_next" onclick="nextPage()">Siguiente</button>
    <div style="display: inline-block; position:relative; border: 0px solid #e3e3e3; float: center; margin-left: 2px;;">
      <p style="position:relative; font-size: 14px;"> Tabla : <span id="page"></span></p>
    </div>
    <select name="number_of_rows" id="number_of_rows">
      <option value="10">10</option>
      <option value="25">25</option>
      <option value="50">50</option>
      <option value="100">100</option>
    </select>
    <button class="button" id="btn_apply" onclick="apply_Number_of_Rows()">Aplicar</button>
  </div>
  <br>
  <script>
    //script para sacar fecha actual y de los ultimos 6 dias
    // let fechas = [];
    // for(let i = 0; i < 7; i++){
    //     let fecha = new Date();
    //     fecha.setDate(fecha.getDate() - i);
    //     fechas.push(fecha.toISOString().split('T')[0]);
    // }
    // console.log(fechas);
    var arraypluvi = [];
    var arrayfecha = [];
    var arraytemp = [];
    var arrayhum = [];
    var arrayhora = [];
    //------------------------------------------------------------
    var current_page = 1;
    var records_per_page = 10;
    var l = document.getElementById("table_id").rows.length
    //------------------------------------------------------------
    function apply_Number_of_Rows() {
      var x = document.getElementById("number_of_rows").value;
      records_per_page = x;
      changePage(current_page);
    }
    //------------------------------------------------------------
    function prevPage() {
      if (current_page > 1) {
        current_page--;
        changePage(current_page);
        fechaa()
        myChart.update()
      }
    }
    //------------------------------------------------------------
    function nextPage() {
      if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
      }
    }
    //------------------------------------------------------------
    function changePage(page) {
      var btn_next = document.getElementById("btn_next");
      var btn_prev = document.getElementById("btn_prev");
      var listing_table = document.getElementById("table_id");
      var page_span = document.getElementById("page");
      // Validate page
      if (page < 1) page = 1;
      if (page > numPages()) page = numPages();

      [...listing_table.getElementsByTagName('tr')].forEach((tr) => {
        tr.style.display = 'none'; // reset all to not display
      });
      listing_table.rows[0].style.display = ""; // display the title row

      for (var i = (page - 1) * records_per_page + 1; i < (page * records_per_page) + 1; i++) {
        if (listing_table.rows[i]) {
          listing_table.rows[i].style.display = ""
          //listing_table.rows contiene el valor de cada elemento a poner en la tabla , buscar variable que controla la cantidad
          //console.log(listing_table.rows[i].style.display);
          //extrae datos especificos de la tabla
          var row = listing_table.rows[i];
          console.log(row)
          var children = row.children;
          var fecha = row.children[7];
          var temp = row.children[1];
          var hum = row.children[3];
          var hora = row.children[6];
          var pluvi = row.children[5];
          var valorpluvi = pluvi.innerText;
          var valortemp = temp.innerText;
          var valorfecha = fecha.innerText;
          var valorhum = hum.innerText;
          var valorhora = hora.innerText;
          //push para cambiar el sentido de la grafica
          arraypluvi.unshift(valorpluvi);
          arrayfecha.unshift(valorfecha);
          arraytemp.unshift(valortemp);
          arrayhum.unshift(valorhum);
          arrayhora.unshift(valorhora);
          // console.log(valortemp);
          // console.log(valor);
          fechaa;
          if (myChart) {
            myChart.update();
          }
        }
      }
      const constlowbatery = 100;
      if (arraypluvi >= constlowbatery) {
        console.log("bateria baja")
        ///pasar todo a javascritp
      }
      console.log(arraypluvi);
      console.log(arrayfecha);
      console.log(arraytemp);
      console.log(arrayhum);
      console.log(arrayhora);

      page_span.innerHTML = page + "/" + numPages() + " (Total numero de filas = " + (l - 1) + ") | Numero de filas : ";

      if (page == 0 && numPages() == 0) {
        btn_prev.disabled = true;
        btn_next.disabled = true;
        return;
      }

      if (page == 1) {
        btn_prev.disabled = true;
      } else {
        btn_prev.disabled = false;
      }

      if (page == numPages()) {
        btn_next.disabled = true;
      } else {
        btn_next.disabled = false;
      }
    }
    //------------------------------------------------------------
    function numPages() {
      return Math.ceil((l - 1) / records_per_page);
    }
    //------------------------------------------------------------
    window.onload = function () {
      var x = document.getElementById("number_of_rows").value;
      records_per_page = x;
      changePage(current_page);
    };
    //------------------------------------------------------------
  </script>
  <h1>GRAFICO DE TIEMPO</h1>
  <div id="graficocanvas"
    style="height:80vh; width:100vw; margin: 0; display: flex; justify-content: center; align-items: center;">
    <canvas id="myChart"></canvas>
  </div>
  <script>
    var data = <?php echo json_encode($data); ?>;
    console.log(data);
    var arraytemperaturatotal = <?php echo json_encode($arraytemperaturate); ?>;
    console.log(arraytemperaturatotal);
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: arrayfechaexactatotal,
        datasets: [{
          label: 'Temperatura',
          data: arraytemp,
          borderColor: 'rgba(255, 99, 132, 1)',
          fill: false
        }, {
          label: 'Humedad',
          data: arrayhum,
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
    if (myChart) {
      myChart.update();
    }
    console.log(arrayfechaexactatotal);
  </script>
</body>
<footer>
</footer>
</html>