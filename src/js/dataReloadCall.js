/**
 * Pone un delay para funciones asíncronas.
 * 
 * @param {int} ms Los milisegundos del delay.
 */
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

let temperature=document.getElementById("temperatureHolder");

async function dataReload() {

    try {
        const response = await fetch("src/controllers/record_controller.php");
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();

        if (data.error) {
            console.error(data.error);
        } else {
            console.log(data);
            temperatureHolder.textContent = data.datatest; 
        }
    } catch (error) {
        console.error("Error al obtener los datos:", error);
    }

    await sleep(10000); // 10 segundos
    dataReload();
}

dataReload();