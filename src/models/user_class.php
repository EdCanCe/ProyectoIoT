<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/encript.php"; //Enlace al documento que encripta las keys

/**
 * Definición de la clase User, la cuál
 * contendrá sus atributos y métodos.
 */
class User {
    private $idUser;
    private $username;
    private $fLastName;
    private $mLastName;
    private $accessKey;

    public function __construct($newIDUser, $newUsername, $newFLastName, $newMLastName, $newAccessKey);

    public function getIDUser();
    public function getUsername();
    public function getFLastName();
    public function getMLastName();

    public function setUsername($newUsername);
    public function setFLastName($newFLastName);
    public function setMLastName($newMLastName);
    public function setAccessKey($newAccessKey);

    public function compareAccessKey($accessKeyB);

    public function itExists();
    public function addToDB();
    public function loadFromDB($identifier);
}