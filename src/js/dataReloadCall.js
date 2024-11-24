/**
 * Pone un delay para funciones asíncronas.
 * 
 * @param{int} ms Los milisegundos del delay.
 */
function sleep(ms){
    return new Promise(resolve => setTimeout(resolve, ms));
}

let ppmCurrentText;
let ppmAvgText;
let ppmMaxText;
let ppmMinText;
let ppmStatusContainer;
let ppmStatusText;
let ppmStatusDesc;

async function query(idDevice, key, type){
    try{
        const response = await fetch("../src/controllers/record_controller.php?id="+String(idDevice)+"&key="+key+"&type="+String(type));
        if (!response.ok){
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        if (data.error){
            console.error(data.error);
        }else{
            return data;
        }
    } catch (error){
        console.error("Error while obtaining data.", error);
    }
}

async function dataReload(idDevice, key){
    /**
     * 0 = Última línea
     * 1 = Último día
     * 2 = 10 últimos días
     * 3 = Último mes
     * 4 = 3 Últimos meses
     */

    let result = await query(idDevice, key, 0);
    ppmCurrentText.textContent = result.Ppm;

    await sleep(2000); // 2 segundos
    dataReload(idDevice, key);
}

async function setup(idDevice, key){//Maneja los máximos y mínimos, así como el llenado de los arreglos de los distintos datos.
    ppmCurrentText = document.getElementById("ppm-text-holder");
    ppmAvgText = document.getElementById("ppm-text-holder-prom");
    ppmMaxText = document.getElementById("ppm-text-holder-prom");
    ppmMinText = document.getElementById("ppm-text-holder-prom");
    ppmStatusContainer = document.getElementById("ppm-status-container");
    ppmStatusText = document.getElementById("ppm-status-text-holder");
    ppmStatusDesc = document.getElementById("ppm-status-text-description");

    dataReload(idDevice, key);
}