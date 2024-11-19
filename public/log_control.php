<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php";

function logout(){
    renderHeader("Cerrar Sesión", 1, ["JS"], ["CSS"]);
    if(isset($_SESSION["IDUser"])){
        session_destroy();
    }
}

function login(){
    renderHeader("Iniciar Sesión", 1, ["JS"], ["CSS"]);
}

function createAccount(){
    renderHeader("Crear Cuenta", 1, ["JS"], ["CSS"]);
}

if(isset($_GET["type"])){//La variable que indica si se inicia o cierra sesión.

    $type=intval($_GET["type"]);

    if($type==0){//Se cierra sesión
        logout();    
    }else if($type==1){//Se inicia sesión
        login();
    }else if($type==2){//Se creSa cuenta
        createAccount();
    }

}else{//No se tiene la variable, manda error

}