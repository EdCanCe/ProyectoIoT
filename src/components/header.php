<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos. La dirección se pone como si fuera del elemento que la llama, es decir, un elemento en /public
require_once "../src/components/button.php"; //Carga el creador de elementos

session_start(); //Inicia la sesión

/**
 * Crea el header de la página.
 * 
 * @param string $pageTitle El título de la página.
 * @return string El HTML del header de la página.
 */
function renderHeader($pageTitle){
    //Crea el esqueleto básico del head
    $html = <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="utf8mb4"> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$pageTitle</title>
            <link rel="stylesheet" href="src/styles/main.css">
            <script src="src/js/redirect.js"></script>
        </head>
        <body>
            <header>
HTML;

    //Verifica si el usuario ya inició sesión para desplegar distintas opciones en el header
    if(isset($_SESSION["IDUser"])){ //SDespliega esto si el usuario SI inició sesión
        $html = $html . createButton("redirect('logout')", "LOGOUT", "");
    }else{ //Despliega esto si el usuario NO inició sesión
        $html = $html . createButton("redirect('login')", "LOGIN", "");
    }

    return $html;
}