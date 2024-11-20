<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php";
require_once "../src/utils/offset_adress.php";
require_once "../src/utils/redirect.php";

function logout(){
    renderHeader("Cerrar Sesión", 1, ["JS"], ["CSS"]);
    session_destroy();
    session_start();
    redirect("home");
}

function login(){
    renderHeader("Iniciar Sesión", 1, ["JS"], ["CSS"]);
    if(isset($_SESSION["IDUser"])){
        redirect("error/No+se+puede+iniciar+sesión.+Cierre+sesión+porfavor");
    }else{
        session_destroy();
        session_start(); 
        $adressSetter = offsetAdress(0); ?>
        <form action="<?php echo $adressSetter?>src/controllers/user_controller.php" method="post" enctype="multipart/form-data">
            <input placeholder="Nombre de usuario" type="text" name="Username" required>
            <input placeholder="Contraseña" type="password" name="AccessKey" required>
            <button type="submit">Iniciar Sesión</button> 
        </form>
    <?php }
}

function createAccount(){
    renderHeader("Crear Cuenta", 1, ["JS"], ["CSS"]);
    if(isset($_SESSION["IDUser"])){
        redirect("error/No+se+puede+crear+una+cuenta.+Cierre+sesión+porfavor");
    }else{
        session_destroy();
        session_start();
        $adressSetter = offsetAdress(0); ?>
        <form action="<?php echo $adressSetter?>src/controllers/user_controller.php" method="post" enctype="multipart/form-data">
            <input placeholder="Nombre de usuario" type="text" name="Username" required>
            <input placeholder="Nombre de pila" type="text" name="GivenName" required>
            <input placeholder="Apellido paterno" type="text" name="FLastName" required>
            <input placeholder="Apellido materno" type="text" name="MLastName">
            <input placeholder="Contraseña" type="password" name="AccessKey" required>
            <button type="submit">Crear cuenta</button> 
        </form>
    <?php }
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