<?php
require_once "../config/db_connection.php"; // Enlace al documento que se conecta a la base de datos
require_once "../utils/encrypt.php"; // Enlace al documento que encripta las keys
require_once "record_class.php"; // Enlace al documento que define la clase de registros.

/**
 * Definición de la clase Device, la cual
 * contendrá sus atributos y métodos.
 */
class Device{
    private $idDevice;
    private $accessKey;
    private $place;

    /**
     * Constructor de la clase Device.
     * Inicializa los valores del dispositivo con los parámetros proporcionados.
     * Si no se proporciona una clave de acceso, se genera una automáticamente basada en la fecha y hora actual.
     *
     * @param int $newIdDevice El ID del dispositivo
     * @param string $newAccessKey La clave de acceso del dispositivo, puede ser encriptada
     * @param string $newPlace El lugar donde está el dispositivo
     */
    public function __construct($newIdDevice = null, $newAccessKey = null, $newPlace = null){
        $this->idDevice = $newIdDevice;
        $this->accessKey = isset($newAccessKey) ? $newAccessKey : encrypt(date('y/m/d-H:i'), 20);
        $this->place = $newPlace;
    }

    /**
     * Obtiene el ID del dispositivo.
     *
     * @return int ID del dispositivo
     */
    public function getIdDevice(){
        return $this->idDevice;
    }

    /**
     * Obtiene la ubicación asociada al dispositivo.
     *
     * @return string Ubicación del dispositivo
     */
    public function getPlace(){
        return $this->place;
    }

    /**
     * Genera y establece una nueva clave de acceso para el dispositivo.
     * La clave se encripta utilizando la fecha y hora actual.
     */
    public function setAccessKey(){
        $this->accessKey = encrypt(date('y/m/d-H:i'), 20);
    }

    /**
     * Establece una nueva ubicación para el dispositivo.
     *
     * @param string $newPlace Nueva ubicación del dispositivo
     */
    public function setPlace($newPlace){
        $this->place = $newPlace;
    }

    /**
     * Compara la clave de acceso del dispositivo con una clave proporcionada.
     *
     * @param string $accessKeyB Clave de acceso a comparar
     * @return bool Verdadero si las claves coinciden, falso en caso contrario
     */
    public function compareAccessKey($accessKeyB){
        return $this->accessKey === $accessKeyB;
    }

    /**
     * Verifica si el dispositivo ya existe en la base de datos.
     * Busca en la base de datos utilizando el ID y la clave de acceso del dispositivo.
     *
     * @return bool Verdadero si el dispositivo existe, falso en caso contrario
     */
    public function itExists(){
        global $connection;
        $query = "SELECT COUNT(IDDevice) AS NUMS FROM Device WHERE IDDevice=$this->idDevice AND AccessKey='$this->accessKey'";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        if($result["NUMS"]==1) return true;
        return false;
    }

    /**
     * Inserta el dispositivo en la base de datos.
     */
    public function addToDB(){
        global $connection;
        $query = "INSERT INTO Device (AccessKey, Place) VALUES ('$this->accessKey', '$this->place')";
        mysqli_query($connection, $query); // Añade el dispositivo a la base de datos

        // Recupera el ID del dispositivo basado en su clave de acceso
        $query = "SELECT IDDevice FROM Device WHERE AccessKey='$this->accessKey'"; //El AccessKey es el momento en que se generó el objeto
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idDevice = $result["IDDevice"];
    }

    /**
     * Carga los datos del dispositivo desde la base de datos.
     * Utiliza el ID del dispositivo para buscar y cargar sus atributos.
     */
    public function loadFromDB(){
        global $connection;
        $query = "SELECT * FROM Device WHERE IDDevice=$this->idDevice";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idDevice = $result["IDDevice"];
        $this->accessKey = $result["AccessKey"];
        $this->place = $result["Place"];
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en el último día.
     *
     * @return array Lista de objetos `Records` asociados al dispositivo
     */
    public function getLastDay(){
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros
    
        // Consulta para obtener los registros con ReadTime en las últimas 24 horas
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice ReadTime >= NOW() - INTERVAL 1 DAY";
        $result = mysqli_query($connection, $query);
    
        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = new Record(newReadTime: $row["ReadTime"], newTemperature: $row["Temperature"], newHumidity: $row["Humidity"], newPpm: $row["Ppm"], newIdDevice: $row["IDDevice"]);
        }
    
        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en los últimos 10 días.
     *
     * @return array Lista de objetos `Record` asociados al dispositivo.
     */
    public function getLast10Days() {
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros

        // Consulta para obtener los registros con ReadTime en los últimos 10 días
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice ReadTime >= NOW() - INTERVAL 10 DAY";
        $result = mysqli_query($connection, $query);

        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = new Record(
                newReadTime: $row["ReadTime"],
                newTemperature: $row["Temperature"],
                newHumidity: $row["Humidity"],
                newPpm: $row["Ppm"],
                newIdDevice: $row["IDDevice"]
            );
        }

        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en el último mes.
     *
     * @return array Lista de objetos `Record` asociados al dispositivo.
     */
    public function getLastMonth() {
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros

        // Consulta para obtener los registros con ReadTime en el último mes
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice ReadTime >= NOW() - INTERVAL 1 MONTH";
        $result = mysqli_query($connection, $query);

        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = new Record(
                newReadTime: $row["ReadTime"],
                newTemperature: $row["Temperature"],
                newHumidity: $row["Humidity"],
                newPpm: $row["Ppm"],
                newIdDevice: $row["IDDevice"]
            );
        }

        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en los últimos 3 meses.
     *
     * @return array Lista de objetos `Record` asociados al dispositivo.
     */
    public function getLast3Months() {
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros

        // Consulta para obtener los registros con ReadTime en los últimos 3 meses
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice ReadTime >= NOW() - INTERVAL 3 MONTH";
        $result = mysqli_query($connection, $query);

        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)) {
            $records[] = new Record(
                newReadTime: $row["ReadTime"],
                newTemperature: $row["Temperature"],
                newHumidity: $row["Humidity"],
                newPpm: $row["Ppm"],
                newIdDevice: $row["IDDevice"]
            );
        }

        return $records; // Devuelve el arreglo de objetos Record
    }
}