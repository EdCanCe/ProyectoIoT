<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php";

//Verifica si hay algún valor para ingresar a la base de datos
if (isset($_GET["text"])) {
    echo renderHeader("Inserción", 1, array("dataReloadCall", "redirect"), array("main"));
    $text = $_GET["text"];

    $query = "INSERT INTO mydata(datatest) VALUES ('$text');";
    $result = mysqli_query($connection, $query);

    $query = "SELECT datatest FROM mydata";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>".$row["datatest"]."</p>";
    }
}else{ 
    echo renderHeader("Wasa", 0, array("dataReloadCall", "redirect"), array("main"));
}