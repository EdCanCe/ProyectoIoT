<?php require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php"; //Enlace al documento que genera los headers
require_once "../src/components/info.php"; //Enlace al documento con la información del proyecto
//require_once "../src/models/user_class.php"; //Enlace al documento que define la clase usuario

echo renderHeader($info["proyect"]["name"], 0, array("dataReloadCall", "redirect"), array("welcome")); ?>

<section class="first">
    <div class="image_back"></div>

    <div class="principal">
        <div class="principal_info">
            <h1 class="title">AIRALYZE</h1>
            <h3 class="slogan">Cada dato importa: tecnología que respira por ti.</h3>
        </div>
    
        <div class="image-collection">
            <img class="image1" src="./src/styles/images/welcome/image1.png" alt="">
            <img class="image2" src="./src/styles/images/welcome/image2.png" alt="">
            <img class="image3" src="./src/styles/images/welcome/image3.png" alt="">
            <img class="image4" src="./src/styles/images/welcome/image4.png" alt="">
        </div>
    </div>

</section>

<section class="second">
    <div class="principal2">
        <div class="imagecollection2">
            <img src="./src/styles/images/welcome/image5.jpg" alt="" class="image5">
            <img src="./src/styles/images/welcome/image6.png" alt="" class="image6">
            <img src="./src/styles/images/welcome/image7.jpg" alt="" class="image7">
        </div>

    </div>
</section>


<p>La temperatura actual es: <span id="temperatureHolder">0</span></p>