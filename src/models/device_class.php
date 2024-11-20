<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/encrypt.php"; //Enlace al documento que encripta las keys
require_once "user_class.php"; //Enlace al documento que define la clase usuario

/**
 * Definición de la clase Device, la cuál
 * contendrá sus atributos y métodos.
 */
class Device{
    private $idDevice;
    private $accessKey;
    private $place;

    public function __construct($idDevice, $accessKey, $place);

    public function getIdDevice();
    public function getPlace();
    public function getAccessKey();

    public function setAccessKey($accessKey);
    public function setPlace($place);

    public function compareAccessKey($accessKeyB);

    public function itExists();
    public function addToDB();
    public function loadFromDB($identifier);
};

/**
 * Definición de la clase UserDevice, la cuál
 * contendrá sus atributos y métodos.
 */
class UserDevice {
    private $idUser;
    private $idDevice;

    public function __construct($idUser, $idDevice);

    public function getIdUser();
    public function getIdDevice();
}