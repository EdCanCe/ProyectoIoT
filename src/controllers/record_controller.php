<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos

//Hace una consulta para obtener la última lectura de datos
$query = "SELECT datatest FROM mydata ORDER BY fecha DESC LIMIT 1";
$result = mysqli_query($connection, $query);

//Devuelve la última fila en un formato JSON
if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "No data found"]);
}
?>