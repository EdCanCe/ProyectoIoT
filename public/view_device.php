<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php"; //Enlace al documento que genera los headers
require_once "../src/components/info.php"; //Enlace al documento con la información del proyecto
require_once "../src/models/user_class.php"; //Enlace al documento que define la clase usuario
require_once "../src/models/device_class.php"; //Enlace al documento que define la clase del dispositivo

echo renderHeader($info["proyect"]["name"], 1, array("dataReloadCall", "redirect"), array("welcome"));

$adressSetter = offsetAdress(1); //Quita el offset de la dirección

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $device = new Device(newIdDevice: $id);

    if(!$device->itExists()) redirect("error/No+existe+este+dispositivo.");

    $userDevice = new UserDevice(isset($_SESSION["IDUser"]), $id);
    if(!$userDevice->itExists()) redirect("error/No+tiene+permisos+para+ver+este+dispositivo.");

    //Pasando este punto se confirma que el usuario tiene permiso para ver este dispositivo.
    

}else{
    redirect("home"); //Como no tiene declarado el ID del dispositivo, mejor lo regresa a la pantalla de inicio.
}