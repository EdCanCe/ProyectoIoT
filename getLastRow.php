<?php
include('database.php'); // Aquí debe estar tu conexión

// Consulta para obtener la última fila basada en una columna (por ejemplo, un ID auto-incremental)
$query = "SELECT datatest FROM mydata";
$result = mysqli_query($connection, $query);

// Si se encuentra una fila, devolver los datos en formato JSON
/*if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'No data found']);
}*/
echo json_encode(['aaaa' => 'preba']);
?>
