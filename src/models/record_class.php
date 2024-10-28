<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/encript.php"; //Enlace al documento que encripta las keys
require_once "user_class.php"; //Enlace al documento que define la clase usuario
require_once "device_class.php"; //Enlace al documento que define la clase de dispositivo

/**
 * Definición de la clase Record, la cuál
 * contendrá sus atributos y métodos.
 */
class Record{
    private $idRecord;
    private $readTime;
    private $temperature;
    private $humidity;
    private $ppm;
    private $idDevice;

    public function __construct($idRecord, $readTime, $temperature, $humidity, $ppm, $idDevice);

    public function getIdRecord();
    public function getReadTime();
    public function getTemperature();
    public function getHumidity();
    public function getPpm();
    public function getIdDevice();

    public function setTemperature($temperature);
    public function setHumidity($humidity);
    public function setPpm($ppm);
    public function setIdDevice($idDevice);

    public function itExists();
    public function addToDB();
    public function loadFromDB($identifier);
};