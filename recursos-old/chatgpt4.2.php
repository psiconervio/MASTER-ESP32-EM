<?php
include("database.php");
try {
    $pdo = Database::connect();
    $pdo->beginTransaction(); // Inicia una transacción

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

    $pdo->commit(); // Confirma la transacción
} catch (Exception $e) {
    $pdo->rollBack(); // Revierte la transacción en caso de error
    error_log("Error al actualizar los datos diarios: " . $e->getMessage()); // Registra el error
} finally {
    Database::disconnect(); // Cierra la conexión a la base de datos
}
?>