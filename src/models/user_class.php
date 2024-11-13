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

    public function __construct($newUsername, $newFLastName, $newMLastName, $newAccessKey);

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

/**
 * Constructor de usuario.
 * 
 * @param string $newUsername El username del usuario.
 * @param string $newFLastName El apellido paterno del usuario.
 * @param string $newMLastName El apellido materno del usuario.
 * @param string $newAccessKey La contraseña del usuario.
 */
function User::__construct($newUsername, $newFLastName, $newMLastName, $newAccessKey) {
    $this->username = $newUsername;
    $this->fLastName = $newFLastName;
    $this->mLastName = $newMLastName;
    $this->accessKey = encript($newAccessKey, 25);
}

function User::getIDUser() {
    return $this->idUser;
}

function User::getUsername() {
    return $this->username;
}

function User::getFLastName() {
    return $this->fLastName;
}

function User::getMLastName() {
    return $this->mLastName;
}

function User::setUsername($newUsername) {
    $this->username = $newUsername;
}

function User::setFLastName($newFLastName) {
    $this->fLastName = $newFLastName;
}

function User::setMLastName($newMLastName) {
    $this->mLastName = $newMLastName;
}

function User::setAccessKey($newAccessKey) {
    $this->accessKey = $newAccessKey;
}

function User::compareAccessKey($accessKeyB) {
    return $this->accessKey === $accessKeyB;
}

function User::itExists() {
    // Implementación de verificación de existencia
}

function User::addToDB() {
    // Implementación para agregar usuario a la base de datos
}

function User::loadFromDB($identifier) {
    // Implementación para cargar datos de la base de datos
}