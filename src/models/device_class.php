<?php
require_once "../config/db_connection.php"; // Enlace al documento que se conecta a la base de datos
require_once "../utils/encrypt.php"; // Enlace al documento que encripta las keys

/**
 * Definición de la clase Device, la cual
 * contendrá sus atributos y métodos.
 */
class Device{
    private $idDevice;
    private $accessKey;
    private $place;

    public function __construct($newIdDevice = null, $newAccessKey = null, $newPlace = null){
        $this->idDevice = $newIdDevice;
        $this->accessKey = isset($newAccessKey) ? $newAccessKey : encrypt(date('y/m/d-H:i'), 20);
        $this->place = $newPlace;
    }

    public function getIdDevice(){
        return $this->idDevice;
    }

    public function getPlace(){
        return $this->place;
    }

    public function setAccessKey(){
        $this->accessKey = encrypt(date('y/m/d-H:i'), 20);
    }

    public function setPlace($newPlace){
        $this->place = $newPlace;
    }

    public function compareAccessKey($accessKeyB){
        return $this->accessKey === $accessKeyB;
    }

    public function itExists(){
        global $connection;
        $query = "SELECT COUNT(IDDevice) AS NUMS FROM Device WHERE IDDevice=$this->idDevice AND AccessKey='$this->accessKey'";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        if($result["NUMS"]==1) return true;
        return false;
    }

    public function addToDB(){
        global $connection;
        $query = "INSERT INTO Device (AccessKey, Place) VALUES ('$this->accessKey', '$this->place')";
        mysqli_query($connection, $query); // Añade el dispositivo a la base de datos

        $query = "SELECT IDDevice FROM Device WHERE AccessKey='$this->accessKey'"; //El AccessKey es el momento en que se generó el objeto
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idDevice = $result["IDDevice"];
    }

    public function loadFromDB(){
        global $connection;
        $query = "SELECT * FROM Device WHERE IDDevice=$this->idDevice";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idDevice = $result["IDDevice"];
        $this->accessKey = $result["AccessKey"];
        $this->place = $result["Place"];
    }
}