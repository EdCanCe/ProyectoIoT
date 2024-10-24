function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

let a=5;
let temperature=document.getElementById("temperatureHolder");

async function dataReload(){

    try {
        // Realizamos la solicitud al archivo PHP
        const response = await fetch('getLatestRow.php');
        const data = await response.json(); // Convertimos la respuesta a JSON

        // Comprobamos si hay un error en los datos
        if (data.error) {
            console.error(data.error);
        } else {
            console.log(data); // Aquí están los datos de la última fila
            // Puedes actualizar tu página o DOM con los datos recibidos
            document.getElementById('temperatureHolder').textContent = data.temperatura+" "+a; // Ejemplo
        }
    } catch (error) {
        console.error('Error al obtener los datos:', error);
    }

    await sleep(5000); //5 segundos
    dataReload();
}

dataReload();