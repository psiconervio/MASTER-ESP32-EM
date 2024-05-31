<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Fecha</title>
</head>
<body>
    <!-- Formulario HTML -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="fecha">Selecciona una fecha:</label>
        <input type="date" name="fecha" id="fecha">
        <button type="submit">Enviar</button>
    </form>

    <?php
    require_once 'conexion/database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fecha = $_POST['fecha'];
        print_r($fecha);

        if (!empty($fecha)) {
            // Conectar a la base de datos usando la clase Database
            $pdo = Database::connect();

            try {
                // Preparar la consulta SQL con un marcador de posición
                $sql = "SELECT * FROM esp32_01_tableupdatedia WHERE fecha >= DATE_SUB(:fecha, INTERVAL 7 DAY)";
                $stmt = $pdo->prepare($sql);

                // Enlazar la variable $fecha al marcador de posición
                $stmt->bindParam(':fecha', $fecha);

                // Ejecutar la consulta
                $stmt->execute();

                // Obtener los resultados
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Procesar los resultados
                if ($stmt->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "ID: " . $row["max_temp"] . " - Fecha: " . $row["fecha"] . "<br>";
                    }
                } else {
                    echo "No se encontraron registros";
                }
            } catch (PDOException $e) {
                echo "Error de consulta: " . $e->getMessage();
            }

            // Desconectar de la base de datos
            Database::disconnect();
        } else {
            echo "La fecha no puede estar vacía";
        }
    }
    ?>
</body>
</html>
