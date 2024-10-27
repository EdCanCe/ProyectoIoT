<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "button.php" //Carga el creador de elementos

/**
 * Crea el header de la página.
 * 
 * @param string $pageTitle El título de la página.
 * @return string El HTML del header de la página.
 */
function renderHeader($pageTitle){
    $html = ""; //Inicializa la variable

    //Verifica si el usuario ya inició sesión para desplegar distintas opciones en el header
    if(isset($_SESSION["IDUser"])){ ?> <!-- Despliega esto si el usuario SI inició sesión -->
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="utf8mb4"> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$pageTitle</title> <!-- Título que aparece en la pestaña del navegador -->
            <link rel="stylesheet" href="styles.css"> <!-- Enlace a la hoja de estilos CSS -->
            <script src="script.js"></script> <!-- Enlace a un archivo JavaScript -->
        </head>
        <body>
            <p>Se inició sesión</p>
        HTML;
    <?php } else{ ?> <!-- Despliega esto si el usuario NO inició sesión -->
        $html = <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="utf8mb4"> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$pageTitle</title> <!-- Título que aparece en la pestaña del navegador -->
            <link rel="stylesheet" href="styles.css"> <!-- Enlace a la hoja de estilos CSS -->
            <script src="script.js"></script> <!-- Enlace a un archivo JavaScript -->
        </head>
        <body>
            <p>Se inició sesión</p>
        HTML;
    <?php }

    return $html;
}