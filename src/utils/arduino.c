#include <WiFi.h>

#include <HTTPClient.h>

const char * ssid = ''; // Your Wi-Fi SSID
const char * password = ''; // Your Wi-Fi Password
int a = 1;

void setup() {
    Serial.begin(115200);

    // Connect to Wi-Fi
    WiFi.begin(ssid, password);
    Serial.print('Connecting to WiFi...');
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.print('.');
    }
    Serial.println('\nConnected to WiFi!');

}

void loop() {

    if (WiFi.status() == WL_CONNECTED && a == 1) {
        HTTPClient http;
        http.begin('https://edcance.dev/proyectoIoT/datos.php?text=esp32'); // Cambia esto a tu URL
        int httpResponseCode = http.GET(); // Hacer la solicitud GET

        if (httpResponseCode > 0) {
            String payload = http.getString(); // Obtener el payload de la respuesta
            Serial.println(httpResponseCode); // Imprimir el código de respuesta HTTP
            Serial.println(payload); // Imprimir el payload
        } else {
            Serial.print('Error en la solicitud HTTP: ');
            Serial.println(httpResponseCode);
        }
        http.end(); // Liberar recursos
        a++;
    }
    Serial.println('aaa');
    delay(1000);
}