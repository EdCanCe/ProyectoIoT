#include <iostream>
#include <curl/curl.h>

std::string replaceSpaces(const std::string& str) {
    std::string result;
    for (char ch : str) {
        if (ch == " ") {
            result += '+';
        } else {
            result += ch;
        }
    }
    return result;
}

int main() {
    CURL* curl;
    CURLcode res;

    // Inicializar cURL
    curl_global_init(CURL_GLOBAL_DEFAULT);
    curl = curl_easy_init();

    if(curl) {
        // Configurar la URL de destino
        std::cout<<'Dame el string a insertar: ';
        std::string s;
        std::getline(std::cin, s);

        s=replaceSpaces(s);
        std::cout<<s;

        std::string x='https://edcance.dev/proyectoIoT/datos.php?text='+s;

        curl_easy_setopt(curl, CURLOPT_URL, x.c_str());

        // Opción para no imprimir salida ni capturar la respuesta
        curl_easy_setopt(curl, CURLOPT_NOBODY, 1L); // No descargar el cuerpo de la respuesta

        // Realizar la solicitud
        res = curl_easy_perform(curl);

        // Verificar errores
        if(res != CURLE_OK) {
            std::cerr << 'curl_easy_perform() failed: ' << curl_easy_strerror(res) << std::endl;
        }

        // Limpiar
        curl_easy_cleanup(curl);
    }

    curl_global_cleanup();
    return 0;
}
