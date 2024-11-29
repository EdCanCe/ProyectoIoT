<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/offset_adress.php"; //Carga la función que quita los offset en las direcciones
require_once "../models/user_class.php"; //Permite el manejo del usuario
require_once "../utils/redirect.php"; //Permite redireccionar ya sea para errores o para 

if(isset($_POST["IDUser"])){ //Actualización del perfil

}else if(isset($_POST["GivenName"])){ //Creación de perfil
    $user = new User(null, $_POST["Username"]);
    if($user->itExists()) redirect("error/Ya+existe+una+cuenta+con+ese+nombre+de+usuario."); //Verifica si ya existe, ya que no pueden existir 2 usernames iguales.

    //Guarda los datos en $user y lo sube a la base de datos
    $user->setGivenName($_POST["GivenName"]);
    $user->setFLastName($_POST["FLastName"]);
    if(isset($_POST["MLastName"]) && !empty($_POST["MLastName"])) $user->setMLastName($_POST["MLastName"]);
    $user->setAccessKey($_POST["AccessKey"]);
    $user->addToDB();

    //Guarda datos recurrentes en la sesión
    session_start();
    $_SESSION["IDUser"]=$user->getIDUser();
    $_SESSION["Username"]=$user->getUsername();

    redirect("home", false);

}else if(isset($_POST["Username"]) && isset($_POST["AccessKey"])){ //Inicio de sesión
    $user = new User(null, $_POST["Username"]);
    if(!$user->itExists()) redirect("error/No+existe+una+cuenta+con+ese+nombre+de+usuario."); //Verifica si existe la cuenta
    $user->loadFromDB();

    if(!$user->compareAccessKey($_POST["AccessKey"])) redirect("error/No+existe+una+cuenta+con+ese+usuario+y+contraseña."); //Verifica si la contraseña es la misma

    //Guarda datos recurrentes en la sesión
    session_start();
    $_SESSION["IDUser"]=$user->getIDUser();
    $_SESSION["Username"]=$user->getUsername();

    redirect("home", false);

}else if(isset($_POST["Username"])){ //Búsqueda de perfil

}