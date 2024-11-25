<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/offset_adress.php"; //Carga la función que quita los offset en las direcciones
require_once "../models/device_class.php"; //Carga la declaración de la clase del dispositivo
require_once "../models/record_class.php"; //Carga la declaración de la clase de registros

if(isset($_GET["id"])){ //El ID del dispositivo

    $id=$_GET["id"];
    $key=$_GET["key"];
    
    $device=new Device($id, $key);
    if($device->itExists()){ //SI existe ese dispositivo con esa llave
        if(isset($_GET["temperature"])){ //Se va a añadir a la base de datos
            $temperature = $_GET["temperature"];
            $humidity = $_GET["humidity"];
            $ppm = $_GET["ppm"];
    
            $record = new Record(newTemperature: $temperature, newHumidity: $humidity, newPpm: $ppm, newIdDevice: $id);

            $record->addToDB();

        }else{ //Se va a hacer un select
            $type=$_GET["type"];
            if($type==0){
                echo json_encode($device->getLastRow());
            }else if($type==1){
                echo json_encode($device->getLastDay());
            }else if($type==2){
                echo json_encode($device->getLast10Days());
            }else if($type==3){
                echo json_encode($device->getLastMonth());
            }else if($type==4){
                echo json_encode($device->getLast3Months());
            }else if($type==5){
                echo json_encode($device->getLastDayCalc());
            }
        }
    }
}