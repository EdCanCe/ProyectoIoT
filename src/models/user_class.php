<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/encrypt.php"; //Enlace al documento que encripta las keys

/**
 * Definición de la clase User, la cuál
 * contendrá sus atributos y métodos.
 */
class User{
    private $idUser;
    private $givenName;
    private $fLastName;
    private $mLastName;
    private $username;
    private $accessKey;

    /**
     * Constructor de usuario.
     * 
     * @param int $newIdUser El ID del usuario.
     * @param string $newUsername El username del usuario.
     * @param string $newGivenName El nombre del usuario.
     * @param string $newFLastName El apellido paterno del usuario.
     * @param string $newMLastName El apellido materno del usuario.
     * @param string $newAccessKey La contraseña del usuario.
     */
    public function __construct($newIdUser = null, $newUsername = null, $newGivenName = null, $newFLastName = null, $newMLastName = null, $newAccessKey = null){
        $this->idUser = $newIdUser;
        $this->username = $newUsername;
        $this->givenName = $newGivenName;
        $this->fLastName = $newFLastName;
        $this->mLastName = $newMLastName;
        $this->accessKey = isset($newAccessKey) ? encrypt($newAccessKey, 25) : null;
    }

    /**
     * Regresa el ID del usuario.
     * 
     * @return int El ID del usuario si existe.
     */
    public function getIDUser(){
        return $this->idUser;
    }

    /**
     * Regresa el username del usuario.
     * 
     * @return string El username del usuario.
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * Regresa el nombre del usuario.
     * 
     * @return string El nombre del usuario.
     */
    public function getGivenName(){
        return $this->givenName;
    }

    /**
     * Regresa el apellido paterno del usuario.
     * 
     * @return string El apellido paterno del usuario.
     */
    public function getFLastName(){
        return $this->fLastName;
    }

    /**
     * Regresa el apellido materno del usuario.
     * 
     * @return string El apellido materno del usuario.
     */
    public function getMLastName(){
        return $this->mLastName;
    }

    /**
     * Modifica el username del usuario.
     * 
     * @param string $newUsername El nuevo username del usuario.
     */
    public function setUsername($newUsername){
        $this->username = $newUsername;
    }

    /**
     * Modifica el nombre del usuario.
     * 
     * @param string $newGivenName El nuevo nombre del usuario.
     */
    public function setGivenName($newGivenName){
        $this->givenName = $newGivenName;
    }

    /**
     * Modifica el apellido paterno del usuario.
     * 
     * @param string $newFLastName El nuevo apellido paterno del usuario.
     */
    public function setFLastName($newFLastName){
        $this->fLastName = $newFLastName;
    }

    /**
     * Modifica el apellido materno del usuario.
     * 
     * @param string $newMLastName El nuevo apellido materno del usuario.
     */
    public function setMLastName($newMLastName){
        $this->mLastName = $newMLastName;
    }

    /**
     * Modifica la contraseña del usuario después de encriptarla.
     * 
     * @param string $newAccessKey La nueva contraseña del usuario.
     */
    public function setAccessKey($newAccessKey){
        $this->accessKey = encrypt($newAccessKey, 25);
    }

    /**
     * Compara una clave de acceso proporcionada con la almacenada.
     * 
     * @param string $accessKeyB La clave de acceso a comparar.
     * @return bool Verdadero si coinciden, falso de lo contrario.
     */
    public function compareAccessKey($accessKeyB){
        return $this->accessKey === encrypt($accessKeyB, 25);
    }

    /**
     * Determina si el usuario existe en la base de datos.
     * 
     * @return bool Verdadero si existe, falso de lo contrario.
     */
    public function itExists(){
        global $connection;
        $query="";
        if(isset($this->idUser)) $query = "SELECT COUNT(IDUser) AS NUMS FROM User WHERE IDUser=$this->idUser";
        else $query = "SELECT COUNT(IDUser) AS NUMS FROM User WHERE Username='$this->username'";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        if($result["NUMS"]==1) return true;
        return false;
    }

    /**
     * Dado un ID o un Username permite cargar sus datos al objeto.
     */
    public function loadFromDB(){
        global $connection;
        $query="";
        if(isset($this->idUser)) $query = "SELECT * FROM User WHERE IDUser=$this->idUser";
        else $query = "SELECT * FROM User WHERE Username='$this->username'";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idUser = $result["IDUser"];
        $this->username = $result["Username"];
        $this->givenName = $result["GivenName"];
        $this->fLastName = $result["FLastName"];
        $this->mLastName = ($result["MLastName"] === null) ? null : $result["MLastName"];
        $this->accessKey = $result["AccessKey"];
    }

    /**
     * Agrega el usuario a la base de datos.
     */
    public function addToDB(){
        global $connection;
        $query="";
        if(isset($this->mLastName)) $query = "INSERT INTO User(GivenName, FLastName, MLastName, Username, AccessKey) VALUES ('$this->givenName', '$this->fLastName', '$this->mLastName', '$this->username', '$this->accessKey')";
        else $query = "INSERT INTO User(GivenName, FLastName, Username, AccessKey) VALUES ('$this->givenName', '$this->fLastName', '$this->username', '$this->accessKey')";
        mysqli_query($connection, $query); //Añade a la base de datos

        $query = "SELECT IDUser FROM User WHERE Username='$this->username'";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idUser = $result["IDUser"];
    }
}