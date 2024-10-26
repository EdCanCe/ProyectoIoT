<?php require_once '../config/db_connection.php'; //Enlace al documento que se conecta a la base de datos

// Consulta para obtener la última fila basada en una columna (por ejemplo, un ID auto-incremental)
$query = "SELECT datatest FROM mydata ORDER BY fecha DESC LIMIT 1";
$result = mysqli_query($connection, $query);

// Si se encuentra una fila, devolver los datos en formato JSON
if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'No data found']);
}
?>