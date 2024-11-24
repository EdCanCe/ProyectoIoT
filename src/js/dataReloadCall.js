/**
 * Pone un delay para funciones asíncronas.
 * 
 * @param{int} ms Los milisegundos del delay.
 */
function sleep(ms){
    return new Promise(resolve => setTimeout(resolve, ms));
}

let ppmCurrentText = document.getElementById("ppm-text-holder");
let ppmAvgText = document.getElementById("ppm-text-holder-prom");
let ppmMaxText = document.getElementById("ppm-text-holder-prom");
let ppmMinText = document.getElementById("ppm-text-holder-prom");
let ppmStatusContainer = document.getElementById("ppm-status-container");
let ppmStatusText = document.getElementById("ppm-status-text-holder");
let ppmStatusDesc = document.getElementById("ppm-status-text-description");

async function query(idDevice, key, type){
    try{
        const response = await fetch("src/controllers/record_controller.php?id="+String(idDevice)+"&key="+key+"&type="+String(type));
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
        console.error("Error al obtener los datos:", error);
    }
}

async function dataReload(idDevice, key){
    
    let result = query(idDevice, key, 0);
    ppmCurrentText.textContent = result.Ppm;

    await sleep(2000); // 2 segundos
    dataReload();
}

async function setup(idDevice, key){//Maneja los máximos y mínimos, así como el llenado de los arreglos de los distintos datos.
    dataReload(idDevice, key);
}

setup();

