<?php

if (!empty($_POST)) {
    // Capturar los valores POST
    $id = $_POST['id'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $veleta = $_POST['veleta'];
    $anemometro = $_POST['anemometro'];
    $pluviometro = $_POST['pluviometro'];
    
    // Crear un array para almacenar los datos recibidos
    $data = [
        'id' => $id,
        'temperature' => $temperature,
        'humidity' => $humidity,
        'veleta' => $veleta,
        'anemometro' => $anemometro,
        'pluviometro' => $pluviometro
    ];
    
    // Convertir el array a JSON
    $myJSON = json_encode($data);
    
    // Imprimir el JSON
    echo $myJSON;
    
    // Imprimir los datos POST recibidos para depuración
    echo "\nDatos POST recibidos:\n";
    print_r($_POST);
    
    // Imprimir el ID recibido para verificar
    echo "\nID recibido:\n";
    print_r($id);
} else {
    echo "No se recibieron datos POST.";
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
