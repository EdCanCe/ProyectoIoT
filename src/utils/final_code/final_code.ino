/*
  Autores:
  Mauricio Olguín Sánchez - A01711522
  Edmundo Canedo Cervantes - A01645576
  Luisa Fernanda Valdez Guillén - A01711870

  Programa para leer y enviar valores a la base de datos.
*/

// Librerias
#include <DHT.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <HardwareSerial.h>

// ESP32 pin GPIO21 connected to DHT11 sensor
#define DHT11_PIN  13

// Crear una instancia para UART1
HardwareSerial PM2_5_Serial(1);
DHT dht11(DHT11_PIN, DHT11);

//Variables globales
float temp_hum_values[2];
int dust_value;
String baseURL = "https://edcance.dev/IoT/testInsert/";
String url = "";
// String DeviceID = "120";
// Sring DeviceKey = "hhg643loajbdychasnbasbascabdmbcgsad";
// String baseUrl = "https://edcance.dev/IoT/Insert/"+DeviceID+"/"+DeviceKey+"/";

// Clave para WiFi
const char * ssid = "Tec-IoT";
const char * password = "spotless.magnetic.bridge";

void setup() {
  Serial.begin(9600);
  Serial.print("Conectando a WiFi...");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("\nConectado a WiFi!");
  PM2_5_Serial.begin(9600, SERIAL_8N1, 16, 17);  // UART1: RX=16, TX=17 (ajusta según tus pines)
  Serial.println("Iniciando lectura del sensor DC01");
  dht11.begin();
  Serial.println("Iniciando lectura del senor DHT11");
}

void temperature_humidity_sensor(){
  // read humidity
  float humi  = dht11.readHumidity();
  // read temperature in Celsius
  float tempC = dht11.readTemperature();
  if (isnan(tempC) || isnan(humi)) {
    Serial.println("Failed to read from DHT11 sensor!");
    temp_hum_values[0] = -1;
    temp_hum_values[1] = -1;
  } else {
    Serial.print(tempC);
    Serial.print(humi);
    temp_hum_values[0] = tempC;
    temp_hum_values[1] = humi;
  }
}

void dust_sensor() {
  if (PM2_5_Serial.available() > 0) {
    byte data[4];  // Buffer para los 4 bytes del mensaje
    int i = 0;
    // Sincronizar con el byte característico 0xA5
    while (PM2_5_Serial.available() > 0) {
      byte firstByte = PM2_5_Serial.read();
      if (firstByte == 0xA5) {  // Encontramos el inicio de un paquete válido
        data[0] = firstByte;
        i = 1;
        break;
      }
    }
    // Leer los siguientes 3 bytes después de encontrar 0xA5
    while (PM2_5_Serial.available() > 0 && i < 4) {
      data[i] = PM2_5_Serial.read();
      i++;
    }

    // Verifica si los datos leídos corresponden al formato esperado
    if (i == 4 && data[0] == 0xA5) {  // Revisar que el primer byte sea el característico 0xA5
      byte DATAH = data[1];
      byte DATAL = data[2];
      
      // Calcular el valor de concentración de PM2.5
      unsigned int concentration = (DATAH * 128) + (DATAL & 0x7F);
      
      dust_value = (int)concentration;
    }
  } else {
    Serial.println("Bad connection to dust sensor.");
    dust_value = -1;
  }
}

void loop() {
  //Lectura de sensores
  dust_sensor();
  temperature_humidity_sensor();

  // Iniciar tranferencia de datos
  url = baseURL + String(temp_hum_values[0]) + "_" + String(temp_hum_values[1]) + "_" + String(dust_value);

  // url = "https://edcance.dev/IoT/testInsert/" + "30°C" + "60%" + "90 ugr/cm3"
  // url = baseURL + "30/" + "60/" + "90"

  if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(url); // Cambia esto a tu URL
      int httpResponseCode = http.GET(); // Hacer la solicitud GET
      if (httpResponseCode > 0) {
          String payload = http.getString(); // Obtener el payload de la respuesta
          //Serial.println(httpResponseCode); // Imprimir el código de respuesta HTTP
          //Serial.println(payload); // Imprimir el payload
      } else {
          Serial.print("Error en la solicitud HTTP: ");
          Serial.println(httpResponseCode);
      }
      http.end(); // Liberar recursos
  }

  // wait a 2 seconds between readings
  delay(2000); 
}