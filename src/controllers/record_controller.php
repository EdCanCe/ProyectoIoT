<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
//aquí hago las inserciones y la obtención de los datos, lo hago con un if isset de los datos para ver si meto datos u obtengo
require_once "../utils/offset_adress.php"; //Carga la función que quita los offset en las direcciones

if(isset($_GET["id"])){

    $id=$_GET["id"];
    $key=$_GET["key"];
    
    $query = "SELECT COUNT(IDDevice) AS NUMS FROM Device WHERE IDDevice=$id AND AccessKey='$key'";
    $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
    if($result["NUMS"]==1){ //SI existe ese dispositivo
        if(isset($_GET["temperature"])){ //Se va a añadir a la base de datos
            $temperature = $_GET["temperature"];
            $humidity = $_GET["humidity"];
            $ppm = $_GET["ppm"];
    
            $query = "INSERT INTO Record(Temperature, Humidity, Ppm, IDDevice) VALUES ($temperature, $humidity, $ppm, $id);";
            $result = mysqli_query($connection, $query);

        }else{ //Se va a hacer un select
    
        }
    }else{ //Se pasó un dispositivo con una key incorrecta

    }

}else{ //eliminar esto pq es de una prueba
    //Hace una consulta para obtener la última lectura de datos
    $query = "SELECT datatest FROM mydata ORDER BY fecha DESC LIMIT 1";
    $result = mysqli_query($connection, $query);

    //Devuelve la última fila en un formato JSON
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No data found"]);
    }
}