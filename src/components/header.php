<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos. La dirección se pone como si fuera del elemento que la llama, es decir, un elemento en /public
require_once "../src/components/button.php"; //Carga el creador de elementos
require_once "../src/utils/offset_adress.php"; //Carga la función que quita los offset en las direcciones

session_start(); //Inicia la sesión

/**
 * Crea el header de la página.
 * 
 * @param string $pageTitle El título de la página.
 * 
 * @return string El HTML del header de la página.
 */
function renderHeader($pageTitle, $numOfVar, $jsFilenames, $cssFilenames){
    $adressSetter = offsetAdress($numOfVar); //Quita el offset de la dirección

    //Crea el esqueleto básico del head
    $html = <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="utf8mb4"> 
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>$pageTitle</title>
HTML;

    //Añade las direcciones de los archivos de JS
    for($i=0; $i<count($jsFilenames); $i++){
        $html = $html . "<script src='" . $adressSetter . "src/js/" . $jsFilenames[$i] . ".js'></script>";
    }

    //Añade las direcciones de los archivos de CSS
    for($i=0; $i<count($cssFilenames); $i++){
        $html = $html . "<link rel='stylesheet' href='" . $adressSetter . "src/styles/" . $cssFilenames[$i] . ".css'>";
    }

    //Cierra el head e inicia el body con el header
    $html .= <<<HTML
        </head>
        <body>
            <header class='header'>
                <div class="logo-container">
                    <img src="{$adressSetter}src/styles/images/header/logo.png" alt="Logo de la página" class="logo">
                    <h3 class="logo-text">AIRALYZE</h3>
                </div>

                <div class="btn-container">
HTML;

    //Verifica si el usuario ya inició sesión para desplegar distintas opciones en el header
    if(isset($_SESSION["IDUser"])){ //SDespliega esto si el usuario SI inició sesión
        $html = $html . renderButton('redirect("' . $adressSetter . 'logout")', "LOG OUT", "");
        $html = $html . renderButton('redirect("' . $adressSetter . 'devices")', "MY DEVICES", "");
        $html = $html . renderButton('redirect("' . $adressSetter . 'profile")', "MY PROFILE", "");
    }else{ //Despliega esto si el usuario NO inició sesión
        $html = $html . renderButton('redirect("' . $adressSetter . 'login")', "Registro", " btn button-logIn");
        $html = $html . renderButton('redirect("' . $adressSetter . 'signup")', "Iniciar Sesión", " btn button-signUp");
    }

    //Cierra el header
    $html .= <<<HTML
                </div>
            </header>
HTML;

    return $html;
}