<?php include("../src/config/db_connection.php"); //Enlace al documento que se conecta a la base de datos
include("../src/components/header.php");

echo renderHeader("aaa"); ?>

<h1>Prueba de repeticiones:</h1>

<p>La temperatura actual es: <span id="temperatureHolder">0</span></p>

<script src="src/js/dataReloadCall.js"></script>