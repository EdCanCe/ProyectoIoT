<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php";
require_once "../src/utils/offset_adress.php";
require_once "../src/utils/redirect.php";

echo renderHeader("Crear Dispositivo", 0, ["redirect"], ["createAccount", "welcome"]);
if(!isset($_SESSION["IDUser"])){
    redirect("error/No+se+puede+crear+un+dispositivo.+Inicie+sesión+porfavor");
}else{
    $adressSetter = offsetAdress(0); ?>
    <section class="create-account">
        <div class="image_back"></div>
        <div class="container">
            <h2 class="title-createAccount">Crear un dispositivo</h2>
            <form action="<?php echo $adressSetter?>src/controllers/device_controller.php" method="post" enctype="multipart/form-data" class="form-createAccount">
                <div class="form-row">
                    <input placeholder="Lugar donde está el dispositivo" type="text" name="Place" required class="name">
                </div>
                <button type="submit" class="btn-createaccount">Crear dispositivo</button> 
            </form>
        </div>
    </section>
<?php }