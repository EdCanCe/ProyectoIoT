<?php $comingFrom="view_device";
require_once "../src/config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../src/components/header.php"; //Enlace al documento que genera los headers
require_once "../src/components/info.php"; //Enlace al documento con la información del proyecto
require_once "../src/models/user_class.php"; //Enlace al documento que define la clase usuario
require_once "../src/models/device_class.php"; //Enlace al documento que define la clase del dispositivo
require_once "../src/utils/redirect.php"; //Enlace al documento que permite hacer redirecciones

echo renderHeader($info["proyect"]["name"], 1, array("dataReloadCall", "redirect"), array("principal"));

$adressSetter = offsetAdress(1); //Quita el offset de la dirección

if(isset($_GET["id"]) && isset($_SESSION["IDUser"])){
    $id = intval($_GET["id"]);
    $device = new Device(newIdDevice: $id);

    if(!$device->itExists()) redirect("error/No+existe+este+dispositivo.");

    $userDevice = new UserDevice($_SESSION["IDUser"], $id);
    if(!$userDevice->itExists()) redirect("error/No+tiene+permisos+para+ver+este+dispositivo.");

    //Pasando este punto se confirma que el usuario tiene permiso para ver este dispositivo.
    $device->loadFromDB(); ?>

    <section class="show-data">
        <div class="image_back"></div>
        <div class="back"></div>
        <div class="principal">
            <div class="principal-info">
                <h2 class="name-room">
                    <?php echo $device->getPlace()?>
                </h2>
            </div>

            <div class="container-cards">
                <div class="card-ppm">
                    <h2 class="ppm-title">Partículas por millón en el ambiente: </h2>
                    <div class="ppm-indicator">
                        <div class="current-ppm">
                            <h3 class="current"><span id="ppm-text-holder"></span> ppm</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="40px" fill="#e8eaed">
                                <path d="M288 32c0 17.7 14.3 32 32 32l32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128c-17.7 0-32 14.3-32 32s14.3 32 32 32l320
                                0c53 0 96-43 96-96s-43-96-96-96L320 0c-17.7 0-32 14.3-32 32zm64 352c0 17.7 14.3 32 32 32l32 0c53 0 96-43 96-96s-43-96-96-96L32 
                                224c-17.7 0-32 14.3-32 32s14.3 32 32 32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0c-17.7 0-32 14.3-32 32zM128 512l32 0c53 
                                0 96-43 96-96s-43-96-96-96L32 320c-17.7 0-32 14.3-32 32s14.3 32 32 32l128 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0c-17.7 0-32 
                                14.3-32 32s14.3 32 32 32z"/></svg>
                        </div>
                        <div class="ppm-level">
                            <h3 class="level-text">Nivel de partículas:</h3>
                            <div class="level-container" id="ppm-status-container">
                                <h4 class="level" id="ppm-status-text-holder">Correcto</h4>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-indicator-ppm" id="ppm-status-description-holder">El nivel de partículas en el ambiente es apto y no debería causar problemas de salud</h4>
                    <h2 class="text-resume">Resumen diario:</h2>
                    <div class="resume">
                        <ul class="row-titles-ppm">
                            <li>PROM</li>
                            <li>MAX</li>
                            <li>MIN</li>
                        </ul>
                        <ul class="row-values-ppm">
                            <li><span id="ppm-text-holder-prom">90</span> μg/m³</li>
                            <li><span id="ppm-text-holder-max">90</span> μg/m³</li>
                            <li><span id="ppm-text-holder-min">90</span> μg/m³</li>
                        </ul>
                    </div>
                </div>
                <div class="card-humidity">
                    <h2 class="humidity-title">Humedad actual en el ambiente:</h2>
                    <div class="humidity-indicator">
                        <div class="current-humidity">
                            <h3 class="current"><span id="humidity-text-holder"></span> %</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="40px" fill="#e8eaed">
                                <path d="M192 512C86 512 0 426 0 320C0 228.8 130.2 57.7 166.6 11.7C172.6 4.2 181.5 0 191.1 0l1.8 0c9.6 0 18.5 4.2 24.5 11.7C253.8 57.7 
                                384 228.8 384 320c0 106-86 192-192 192zM96 336c0-8.8-7.2-16-16-16s-16 7.2-16 16c0 61.9 50.1 112 112 112c8.8 0 16-7.2 16-16s-7.2-16-16-16c-44.2 
                                0-80-35.8-80-80z"/></svg>
                        </div>
                        <div class="humidity-level">
                            <h3 class="level-text">Nivel de humedad:</h3>
                            <div class="level-container" id="humidity-status-container">
                                <h4 class="level" id="humidity-status-text-holder">Correcto</h4>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-indicator-humidity" id="humidity-status-description-holder">El nivel de humedad en el ambiente esta en optimas condiciones</h4>
                    <h2 class="text-resume">Resumen diario:</h2>
                    <div class="resume">
                        <ul class="row-titles-humidity">
                            <li>PROM</li>
                            <li>MAX</li>
                            <li>MIN</li>
                        </ul>
                        <ul class="row-values-humidity">
                            <li><span id="humidity-text-holder-prom">90</span> %</li>
                            <li><span id="humidity-text-holder-max">90</span> %</li>
                            <li><span id="humidity-text-holder-min">90</span> %</li>
                        </ul>
                    </div>
                </div>
                <div class="card-temperature">
                    <h2 class="temperature-title">Temperatura actual en el ambiente:</h2>
                    <div class="temperature-indicator">
                        <div class="current-temperature">
                            <h3 class="current"><span id="temperature-text-holder"></span> °C</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" fill="#e8eaed">
                                <path d="M480-80q-83 0-141.5-58.5T280-280q0-50 22.33-93.83 22.34-43.84 65-68.17v-325.33q0-46.95 
                                32.86-79.81Q433.06-880 480-880q46.94 0 79.81 32.86 32.86 32.86 32.86 79.81V-442q42.66 24.33 65 68.17Q680-330 680-280q0 
                                83-58.5 141.5T480-80Zm-46-436.67h92v-48.66h-46v-39.34h46v-84.66h-46v-39h46v-39q0-19.55-13.25-32.78-13.25-13.22-32.83-13.22-19.59 
                                0-32.75 13.22Q434-786.88 434-767.33v250.66Z"/></svg>
                        </div>
                        <div class="temperature-level">
                            <h3 class="level-text">Nivel de temperatura:</h3>
                            <div class="level-container" id="temperature-status-container">
                                <h4 class="level" id="temperature-status-text-holder">Correcto</h4>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-indicator-temperature" id="humidity-status-description-holder">El nivel de temperatura en el ambiente esta en optimas condiciones</h4>
                    <h2 class="text-resume">Resumen diario:</h2>
                    <div class="resume">
                        <ul class="row-titles-temperature">
                            <li>PROM</li>
                            <li>MAX</li>
                            <li>MIN</li>
                        </ul>
                        <ul class="row-values-temperature">
                            <li><span id="temperature-text-holder-prom">90</span> °C</li>
                            <li><span id="temperature-text-holder-max">90</span> °C</li>
                            <li><span id="temperature-text-holder-min">90</span> °C</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="statistics">
        <div class="menu">
            <h2 class="view-register">Visualizar registro</h2>
            <div class="options-records">
                <button class="btn-option">Últimos 10 días</button>
                <button class="btn-option">Último mes</button>
                <button class="btn-option">Últimos 3 meses</button>
            </div>  
        </div>
        <div class="main-graph" id="main-graph-container">

        </div>
        <div class="graph-holders">
            <div class="tiny-graph" id="ppm-graph-container"></div>
            <div class="tiny-graph" id="humidity-graph-container"></div>
            <div class="tiny-graph" id="temperature-graph-container"></div>
        </div>
    </section>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>setup(<?php echo $device->getIdDevice() ?>, "<?php echo $device->getKey() ?>")</script>

<?php }else{
    redirect("home"); //Como no tiene declarado el ID del dispositivo, mejor lo regresa a la pantalla de inicio.
}