<?php require_once "../config/db_connection.php"; //Enlace al documento que se conecta a la base de datos
require_once "../utils/encrypt.php"; //Enlace al documento que encripta las keys

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

    /**
     * Constructor de la clase Record.
     * Inicializa los valores del registro con los parámetros proporcionados.
     *
     * @param int $idRecord El ID del registro
     * @param string $readTime La fecha y hora de la lectura
     * @param float $temperature Temperatura registrada
     * @param float $humidity Humedad registrada
     * @param float $ppm PPM registrados
     * @param int $idDevice ID del dispositivo asociado
     */
    public function __construct($newIdRecord = null, $newReadTime = null, $newTemperature = null, $newHumidity = null, $newPpm = null, $newIdDevice = null){
        $this->idRecord = $newIdRecord;
        $this->readTime = $newReadTime;
        $this->temperature = $newTemperature;
        $this->humidity = $newHumidity;
        $this->ppm = $newPpm;
        $this->idDevice = $newIdDevice;
    }

    /**
     * Obtiene el ID del registro.
     *
     * @return int ID del registro
     */
    public function getIdRecord(){
        return $this->idRecord;
    }

    /**
     * Obtiene la fecha y hora de la lectura.
     *
     * @return string Fecha y hora de la lectura
     */
    public function getReadTime(){
        return $this->readTime;
    }

    /**
     * Obtiene la temperatura registrada.
     *
     * @return float Temperatura registrada
     */
    public function getTemperature(){
        return $this->temperature;
    }

    /**
     * Obtiene la humedad registrada.
     *
     * @return float Humedad registrada
     */
    public function getHumidity(){
        return $this->humidity;
    }

    /**
     * Obtiene las PPM registradas.
     *
     * @return float PPM registradas
     */
    public function getPpm(){
        return $this->ppm;
    }

    /**
     * Obtiene el ID del dispositivo asociado.
     *
     * @return int ID del dispositivo asociado
     */
    public function getIdDevice(){
        return $this->idDevice;
    }

    /**
     * Establece una nueva temperatura para el registro.
     *
     * @param float $temperature Nueva temperatura
     */
    public function setTemperature($temperature){
        $this->temperature = $temperature;
    }

    /**
     * Establece una nueva humedad para el registro.
     *
     * @param float $humidity Nueva humedad
     */
    public function setHumidity($humidity){
        $this->humidity = $humidity;
    }

    /**
     * Establece nuevas PPM para el registro.
     *
     * @param float $ppm Nuevas PPM
     */
    public function setPpm($ppm){
        $this->ppm = $ppm;
    }

    /**
     * Establece un nuevo ID de dispositivo para el registro.
     *
     * @param int $idDevice Nuevo ID del dispositivo
     */
    public function setIdDevice($idDevice){
        $this->idDevice = $idDevice;
    }

    /**
     * Inserta el registro actual en la base de datos.
     */
    public function addToDB(){
        global $connection;
        $query = "INSERT INTO Record (Temperature, Humidity, Ppm, IDDevice) VALUES ($this->temperature, $this->humidity, $this->ppm, $this->idDevice)";
        mysqli_query($connection, $query);

        // Obtener el ID generado para el registro y almacenarlo en la clase
        $query = "SELECT IDRecord FROM Record ORDER BY ReadTime DESC LIMIT 1";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $this->idRecord = $result["IDRecord"];
    }
}