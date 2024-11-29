<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/offset_adress.php"; //Carga la función que quita los offset en las direcciones
require_once "../models/user_class.php"; //Permite el manejo del usuario
require_once "../models/device_class.php"; //Permite el manejo del usuario
require_once "../utils/redirect.php"; //Permite redireccionar ya sea para errores o para

session_start();

//Crea el dispositivo en la base de datos
$device = new Device(null, null, $_POST["Place"]);
$device->addToDB();

//Se enlaza el dispositivo creado al usuario
$userDevice = new UserDevice($_SESSION["IDUser"], $device->getIdDevice());
$userDevice->addToDB();

redirect("device/".$device->getIdDevice(), false);