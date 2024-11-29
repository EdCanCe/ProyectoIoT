<?php $extra="";
if(isset($comingFrom)){
    $extra="src/";
}
require_once "../".$extra."config/db_connection.php"; // Enlace al documento que se conecta a la base de datos
require_once "../".$extra."utils/encrypt.php"; // Enlace al documento que encripta las keys
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
        $this->accessKey = $newAccessKey;
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
     * Obtiene la key del dispositivo.
     *
     * @return string Key del dispositivo
     */
    public function getKey(){
        return $this->accessKey;
    }

    /**
     * Genera y establece una nueva clave de acceso para el dispositivo.
     * La clave se encripta utilizando la fecha y hora actual.
     */
    public function setAccessKey(){
        $this->accessKey = encrypt(date('y*m*d*H*i'), 20);
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
        $query="";
        if(isset($this->accessKey)) $query = "SELECT COUNT(IDDevice) AS NUMS FROM Device WHERE IDDevice=$this->idDevice AND AccessKey='$this->accessKey'";
        else $query = "SELECT COUNT(IDDevice) AS NUMS FROM Device WHERE IDDevice=$this->idDevice";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        if($result["NUMS"]==1) return true;
        return false;
    }

    /**
     * Inserta el dispositivo en la base de datos.
     */
    public function addToDB(){
        global $connection;
        if(!isset($this->accessKey)) $this->setAccessKey();
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
     * Obtiene el registro más reciente vinculado a un dispositivo.
     *
     * @return array Datos del registro más reciente como un arreglo asociativo.
     */
    public function getLastRow(){
        global $connection; // Accede a la conexión de la base de datos
        $records=null;
        
        // Consulta para obtener el último registro basado en ReadTime
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice ORDER BY ReadTime DESC LIMIT 1";
        $result = mysqli_query($connection, $query);

        // Si hay resultados, devuelve el primer registro como un array asociativo
        if ($row = mysqli_fetch_assoc($result)){
            $records=[
                "ReadTime" => $row["ReadTime"],
                "Temperature" => $row["Temperature"],
                "Humidity" => $row["Humidity"],
                "Ppm" => $row["Ppm"],
                "IDDevice" => $row["IDDevice"]
            ];
        }

        return $records;
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
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice AND ReadTime >= NOW() - INTERVAL 1 DAY  ORDER BY ReadTime DESC";
        $result = mysqli_query($connection, $query);
    
        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)){
            $records[] = [
                "ReadTime" => $row["ReadTime"],
                "Temperature" => $row["Temperature"],
                "Humidity" => $row["Humidity"],
                "Ppm" => $row["Ppm"],
                "IDDevice" => $row["IDDevice"]
            ];
        }
    
        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en los últimos 10 días.
     *
     * @return array Lista de objetos `Record` asociados al dispositivo.
     */
    public function getLast10Days(){
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros

        // Consulta para obtener los registros con ReadTime en los últimos 10 días
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice AND ReadTime >= NOW() - INTERVAL 10 DAY ORDER BY ReadTime DESC";
        $result = mysqli_query($connection, $query);

        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)){
            $records[] = [
                "ReadTime" => $row["ReadTime"],
                "Temperature" => $row["Temperature"],
                "Humidity" => $row["Humidity"],
                "Ppm" => $row["Ppm"],
                "IDDevice" => $row["IDDevice"]
            ];
        }

        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en el último mes.
     *
     * @return array Lista de objetos `Record` asociados al dispositivo.
     */
    public function getLastMonth(){
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros

        // Consulta para obtener los registros con ReadTime en el último mes
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice AND ReadTime >= NOW() - INTERVAL 1 MONTH ORDER BY ReadTime DESC";
        $result = mysqli_query($connection, $query);

        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)){
            $records[] = [
                "ReadTime" => $row["ReadTime"],
                "Temperature" => $row["Temperature"],
                "Humidity" => $row["Humidity"],
                "Ppm" => $row["Ppm"],
                "IDDevice" => $row["IDDevice"]
            ];
        }

        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en los últimos 3 meses.
     *
     * @return array Lista de objetos `Record` asociados al dispositivo.
     */
    public function getLast3Months(){
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros

        // Consulta para obtener los registros con ReadTime en los últimos 3 meses
        $query = "SELECT ReadTime, Temperature, Humidity, Ppm, IDDevice FROM Record WHERE IDDevice = $this->idDevice AND ReadTime >= NOW() - INTERVAL 3 MONTH ORDER BY ReadTime DESC";
        $result = mysqli_query($connection, $query);

        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)){
            $records[] = [
                "ReadTime" => $row["ReadTime"],
                "Temperature" => $row["Temperature"],
                "Humidity" => $row["Humidity"],
                "Ppm" => $row["Ppm"],
                "IDDevice" => $row["IDDevice"]
            ];
        }

        return $records; // Devuelve el arreglo de objetos Record
    }

    /**
     * Obtiene los registros vinculados a un dispositivo en el último día.
     *
     * @return array Lista de objetos `Records` asociados al dispositivo
     */
    public function getLastDayCalc(){
        global $connection; // Accede a la conexión de la base de datos
        $records = array(); // Arreglo para almacenar los registros
    
        // Consulta para obtener los registros con ReadTime en las últimas 24 horas
        $query = "SELECT ROUND(AVG(Ppm),2) as ppmAvg, MAX(Ppm) as ppmMax, MIN(Ppm) as ppmMin, ROUND(AVG(Humidity),2) as humidityAvg, MAX(Humidity) as humidityMax, MIN(Humidity) as humidityMin, ROUND(AVG(Temperature),2) as temperatureAvg, MAX(Temperature) as temperatureMax, MIN(Temperature) as temperatureMin FROM Record WHERE IDDevice = $this->idDevice AND ReadTime >= NOW() - INTERVAL 1 DAY ORDER BY ReadTime DESC";
        $result = mysqli_query($connection, $query);
    
        // Itera sobre los resultados y crea objetos Record para cada uno
        while ($row = mysqli_fetch_assoc($result)){
            $records = [
                "ppmAvg" => $row["ppmAvg"],
                "ppmMax" => $row["ppmMax"],
                "ppmMin" => $row["ppmMin"],
                "humidityAvg" => $row["humidityAvg"],
                "humidityMax" => $row["humidityMax"],
                "humidityMin" => $row["humidityMin"],
                "temperatureAvg" => $row["temperatureAvg"],
                "temperatureMax" => $row["temperatureMax"],
                "temperatureMin" => $row["temperatureMin"]
            ];
        }
    
        return $records; // Devuelve el arreglo de objetos Record
    }

}