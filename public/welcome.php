<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php"; //Enlace al documento que genera los headers
require_once "../src/components/info.php"; //Enlace al documento con la información del proyecto
require_once "../src/models/user_class.php"; //Enlace al documento que define la clase usuario

echo renderHeader($info["proyect"]["name"], 0, array("dataReloadCall", "redirect"), array("main")); ?>

<h1>Temperatura en tiempo real:</h1>

<p>La temperatura actual es: <span id="temperatureHolder">0</span></p>