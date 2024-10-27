<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php";
require_once "../src/components/info.php";

echo renderHeader($info["proyect"]["name"], 0, array("dataReloadCall", "redirect"), array("main")); ?>

<h1>Prueba de repeticiones:</h1>

<p>La temperatura actual es: <span id="temperatureHolder">0</span></p>