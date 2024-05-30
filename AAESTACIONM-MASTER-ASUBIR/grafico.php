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
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="fecha">Selecciona una fecha:</label>
        <input type="date" name="fecha" id="fecha">
        <button type="submit">Enviar</button>
    </form>
  <h3 style="color: #0c6980;">DATOS ESTACION METEREOLOGICA</h3>
  <table class="styled-table" id="table_id">
    <thead>
      <tr>
        <th>N°</th>
        <th>Temp-max°C</th>
        <th class="hide-on-mobile">Temp-min°C</th>
        <th>Hum(%)</th>
        <th>Velocidad viento</th>
        <th>Caudal lluvia</th>
        <th class="hide-on-mobile">DireViento</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody id="tbody_table_record">
    <!-- <script>
        function obtenerFecha() {
            // Obtiene el elemento input por su id
            var inputFecha = document.getElementById('fecha');
            // Obtiene el valor del input
            var valorFecha = inputFecha.value;
            // Muestra el valor en una alerta
            console.log(valorFecha);
            alert('La fecha seleccionada es: ' + valorFecha);
        }
    </script> -->
      <?php
if (!empty($_POST)) {
  $fecha = $_POST['fecha'];
  print_r($fecha);
}
      include 'conexion/database.php';
      //trabajar con php
//       $num = 0;
//       $arrayfechaexactatotal = [];
//       $arraydateFormat = [];
//       $arraytemperaturate = [];
//       $arrayhumedad = [];
//       //The process for displaying a record table containing the DHT11 sensor data and the state of the LEDs.
       $pdo = Database::connect();
//       // replace_with_your_table_name, on this project I use the table name 'esp32_table_dht11_leds_record'.
//       // This table is used to store and record DHT11 sensor data updated by ESP32. 
//       // This table is also used to store and record the state of the LEDs, the state of the LEDs is controlled from the "home.php" page. 
//       // To store data, this table is operated with the "INSERT" command, so this table will contain many rows.
        $sql = 'SELECT * FROM esp32_01_tableupdatedia ORDER BY fecha DESC';
      //  $sql = 'SELECT * FROM esp32_01_tableupdatedia fecha >= DATE_SUB('tu_fecha_especifica', INTERVAL 7 DAY);';
//       $fechaanterior = null;
//       /// ADAPTAR FRONT ENDDDDD
//       foreach ($pdo->query($sql) as $row) {
//         $date = date_create($row['fecha']);
//         $dateFormat = date_format($date, "d-m-Y");
//        $data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//         $datos[] = [ 'fecha' => $row['fecha'], 'max_temp' => $row['max_temp'],'min_temp' => $row['min_temp'], 'max_humidity' => $row['max_humidity'],'min_humidity' => $row['min_humidity'], 'moda_veleta' => $row['moda_veleta'], 'avg_anemometro' => $row['avg_anemometro'], 'sum_pluviometro' => $row['sum_pluviometro']];
//       //  $longitudarray= count($data); 
//       //print_r($data);  
//         $num++;
//         echo '<tr>';
//         echo '<td>' . $num . '</td>';
//         echo '<td class="bdr">' . $row['max_temp'] . '°C </td>';
//         echo '<td class="bdr">' . $row['min_temp'] . '°C</td>';
//         echo '<td class="bdr">' . $row['max_humidity'] .'%</td>';
//         echo '<td class="bdr">' . $row['avg_anemometro'] .'km/h</td>';
//         echo '<td class="bdr">' . $row['sum_pluviometro'] .'ml</td>';
//         echo '<td class="bdr">' . $row['moda_veleta'] .'</td>';
//         echo '<td>' . $row['fecha'] . '</td>';
//         echo '</tr>';
//         // $arraytemperaturate[] = ['temperaturaa'=>$row['temperature']];
//         $arreglofecha[] = ['fecha' => $row['fecha']];
//         //print_r($datos);
//         //para sacar temperatura de fechas exactas hay que iterrar en el array
//         //para sacar humedad de fechas exactas hay que iterrar en el arrayintentar hacerlo en el array data
      

//         // print_r($row);
//         // array_push($arrayfechaexactatotal,);
//         //array_push($arraydateFormat, $dateFormat);
//       }
      
//       //   $fechaexactacambia = $dateformat;
//       //pasar todos array php a javascript json para el manejo de la logica y asyncs y traer las tablas sea lo esperado
//       Database::disconnect();
  
//       ?>
       <script>
//         let fechas = [];
//         let fechaanterior ;
        //  var data = 
//         //console.log(data);
//         function fechaa() {
//           for (let i = 0; i <= 15; i++) {

//             if (data[i].date !== fechaanterior) {
//               fechas.push(data[i].date);
//               fechaanterior = data[i].date;

//             }
//           }
//          // console.log(fechas);

//           //  hacer una sola funcion para que se ejecute cuando se aprieta el boton
//         }
//         fechaa()
//         //  let fechas = data;
//         // let temperaturadata = data.temperature;

        // var arreglofechas = <?php 
        // echo json_encode($arreglofecha);
         ?>;
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
     <a href="index.php"><button class="button" id="btn_apply" onclick="apply_Number_of_Rows()">Volver al Dashboard</button></a>
     <a href="grafico.php"><button class="button" id="btn_apply" onclick="apply_Number_of_Rows()">Grafico</button></a>
   </div>
   <br>
   <script>
//     //script para sacar fecha actual y de los ultimos 6 dias
//     // let fechas = [];
//     // for(let i = 0; i < 7; i++){
//     //     let fecha = new Date();
//     //     fecha.setDate(fecha.getDate() - i);
//     //     fechas.push(fecha.toISOString().split('T')[0]);
//     // }
//     // console.log(fechas);
//     var arraypluvi = [];
//     var arrayfecha = [];
//     var arraytemp = [];
//     var arrayhum = [];
//     var arrayhora = [];
//     //------------------------------------------------------------
//     var current_page = 1;
//     var records_per_page = 10;
//     var l = document.getElementById("table_id").rows.length
//     //------------------------------------------------------------
//     function apply_Number_of_Rows() {
//       var x = document.getElementById("number_of_rows").value;
//       records_per_page = x;
//       changePage(current_page);
//     }
//     //------------------------------------------------------------
//     function prevPage() {
//       if (current_page > 1) {
//         current_page--;
//         changePage(current_page);
//         fechaa()
//         myChart.update()
//       }
//     }
//     //------------------------------------------------------------
//     function nextPage() {
//       if (current_page < numPages()) {
//         current_page++;
//         changePage(current_page);
//       }
//     }
//     //------------------------------------------------------------
//     function changePage(page) {
//       var btn_next = document.getElementById("btn_next");
//       var btn_prev = document.getElementById("btn_prev");
//       var listing_table = document.getElementById("table_id");
//       var page_span = document.getElementById("page");
//       // Validate page
//       if (page < 1) page = 1;
//       if (page > numPages()) page = numPages();

//       [...listing_table.getElementsByTagName('tr')].forEach((tr) => {
//         tr.style.display = 'none'; // reset all to not display
//       });
//       listing_table.rows[0].style.display = ""; // display the title row

//       for (var i = (page - 1) * records_per_page + 1; i < (page * records_per_page) + 1; i++) {
//         if (listing_table.rows[i]) {
//           listing_table.rows[i].style.display = ""
//           //listing_table.rows contiene el valor de cada elemento a poner en la tabla , buscar variable que controla la cantidad
//           //console.log(listing_table.rows[i].style.display);
//           //extrae datos especificos de la tabla
//           var row = listing_table.rows[i];
//           //console.log(row)
//           var children = row.children;
//           var fecha = row.children[7];
//           var temp = row.children[1];
//           var hum = row.children[3];
//           var hora = row.children[6];
//           var pluvi = row.children[5];
//           var valorpluvi = pluvi.innerText;
//           var valortemp = temp.innerText;
//           var valorfecha = fecha.innerText;
//           var valorhum = hum.innerText;
//           var valorhora = hora.innerText;
//           //push para cambiar el sentido de la grafica
//           //arraypluvi.unshift(valorpluvi);
//           arrayfecha.push(valorfecha);
//           arraytemp.push(valortemp);
//           arrayhum.push(valorhum);
//           //arrayhora.unshift(valorhora);
//           // console.log(children);
//           // console.log(valor);
//           fechaa;
//           if (myChart) {
//             myChart.update();
//           }
//         }
//       }
//       // Remove the °C from the temperature values
//       const funtemp = (str) => {
//         const match = str.match(/(\d+)/);
//         return match ? parseFloat(match[1]) : null;
//       };
//       const temperatures = arraytemp.map(funtemp);

//       console.log(temperatures); // Verifica el contenido de temperatures
//       // Remove the % from the percentage values
//       const funhum = (str) => {
//         const matchh = str.match(/(\d+)/);
//         return matchh ? parseFloat(matchh[1]) : null;
//       };

//       // Map the arrayhum to remove % and convert to numbers
//       const percentages = arrayhum.map(funhum);
//       //console.log(percentages); // Verifica el contenido

//       // Ensure lengths of labels and datasets match
//       if (arrayfecha.length !== temperatures.length || arrayfecha.length !== arrayhum.length) {
//         console.error("Length mismatch between labels and datasets.");
//         return;
//       }

//       // Update Chart.js
//       if (myChart) {
//         myChart.data.labels = arrayfecha;
//         myChart.data.datasets[0].data = temperatures;
//         myChart.data.datasets[1].data = percentages;
//         myChart.update();
//         //console.log(arrayhum)
//       }

//       const constlowbatery = 100;
//       if (arraypluvi >= constlowbatery) {
//        // console.log("bateria baja")
//         ///pasar todo a javascritp
//       }
//       //console.log(arraypluvi);
//       //console.log(arrayfecha);
//       console.log(percentages);
//       console.log(arrayhum);
//       //console.log(arrayhora);

//       page_span.innerHTML = page + "/" + numPages() + " (Total numero de filas = " + (l - 1) + ") | Numero de filas : ";

//       if (page == 0 && numPages() == 0) {
//         btn_prev.disabled = true;
//         btn_next.disabled = true;
//         return;
//       }

//       if (page == 1) {
//         btn_prev.disabled = true;
//       } else {
//         btn_prev.disabled = false;
//       }

//       if (page == numPages()) {
//         btn_next.disabled = true;
//       } else {
//         btn_next.disabled = false;
//       }
//     }
//     //------------------------------------------------------------
//     function numPages() {
//       return Math.ceil((l - 1) / records_per_page);
//     }
//     //------------------------------------------------------------
//     window.onload = function () {
//       var x = document.getElementById("number_of_rows").value;
//       records_per_page = x;
//       changePage(current_page);
//     };
//     //------------------------------------------------------------
//   </script>
     <h1 style="color: #0c6980;">Grafico de Tiempo</h1>

   <div id="graficocanvas" style="height:80vh; width:100vw; margin: 0; display: flex; justify-content: center; ">
     <canvas id="myChart"></canvas>
   </div>
   <script>
//     //console.log(arraytemperaturatotal);
    
//     var ctx = document.getElementById('myChart').getContext('2d');
//     var myChart = new Chart(ctx, {
//       type: 'line',
//       data: {
//         labels: [],
//         datasets: [{
//           label: 'Temperatura',
//           data: [],
//           borderColor: 'rgba(255, 99, 132, 1)',
//           fill: false
//         }, {
//           label: 'Humedad',
//           data: [],
//           borderColor: 'rgba(75, 192, 192, 1)',
//           fill: false
//         }]
//       },
//       options: {
//         responsive: true,
//         scales: {
//           y: {
//             beginAtZero: true
//           }
//         }
//       }
//     });
//     if (myChart) {
//       myChart.update();
//     }
//     //console.log(arrayfechaexactatotal);
//   </script>
   <a href="index.php"><button class="button" id="btn_apply">dashboard</button></a>}
   <button class="button" id="btn_apply">dashboard</button>
</body>
<footer>
</footer>
</html>