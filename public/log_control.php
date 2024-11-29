<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php";
require_once "../src/utils/offset_adress.php";
require_once "../src/utils/redirect.php";

function logout(){
    renderHeader("Cerrar Sesión", 1, ["JS"], ["CSS"]);
    session_destroy();
    session_start();
    redirect("home", false);
}

function login(){
    echo renderHeader("Iniciar Sesión", 0, ["redirect"], ["login"]);
    if(isset($_SESSION["IDUser"])){
        redirect("error/No+se+puede+iniciar+sesión.+Cierre+sesión+porfavor");
    }else{
        session_destroy();
        session_start(); 
        $adressSetter = offsetAdress(0); ?>
        <section class="log-in">
            <div class="image_back"></div>
            <div class="principal">
                <h2 class="title-login">Iniciar Sesión</h2>
                <form action="<?php echo $adressSetter?>src/controllers/user_controller.php" method="post" enctype="multipart/form-data"class="form-login">
                    <div class="user-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="24px" fill="#ffffff">
                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 
                            29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                        <input placeholder="Nombre de usuario" type="text" name="Username" required class="user">
                    </div>
                    <div class="password-container">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="24px" fill="#ffffff">
                            <path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3
                            0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
                        <input placeholder="Contraseña" type="password" name="AccessKey" required class="password">
                    </div>
                    
                    <button type="submit" class="btn-login">Iniciar Sesión</button> 
                </form>
                <p class="link-createAccount">¿No tienes cuenta aún? <a class="link-createAccount" href="#">Regístrate</a></p>
            </div>
        </section>
    <?php }
}

function createAccount(){
    echo renderHeader("Crear Cuenta", 0, ["redirect"], ["createAccount"]);
    if(isset($_SESSION["IDUser"])){
        redirect("error/No+se+puede+crear+una+cuenta.+Cierre+sesión+porfavor");
    }else{
        session_destroy();
        session_start();
        $adressSetter = offsetAdress(0); ?>
        <section class="create-account">
            <div class="image_back"></div>
            <div class="container">
                <h2 class="title-createAccount">Crear una cuenta</h2>
                <form action="<?php echo $adressSetter?>src/controllers/user_controller.php" method="post" enctype="multipart/form-data" class="form-createAccount">
                    <div class="form-row">
                        <input placeholder="Nombre" type="text" name="GivenName" required class="name">
                    </div>
                    <div class="form-row-lastname">
                        <input placeholder="Apellido paterno" type="text" name="FLastName" required class="Flastname">
                        <input placeholder="Apellido materno" type="text" name="MLastName" class="Mlastname">
                    </div>
                    <div class="form-row">
                        <input placeholder="Nombre de usuario" type="text" name="Username" required class="username">
                    </div>
                    <div class="form-row">
                        <input placeholder="Contraseña" type="password" name="AccessKey" required class="password">
                    </div>
                    <button type="submit" class="btn-createaccount">Crear cuenta</button> 
                </form>
                <p class="link-login">¿Ya tienes cuenta? <a class="link-login" href="#">Iniciar Sesión</a></p>
            </div>
        </section>
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