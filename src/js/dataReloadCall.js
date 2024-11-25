/**
 * Pone un delay para funciones asíncronas.
 * 
 * @param{int} ms Los milisegundos del delay.
 */
function sleep(ms){
    return new Promise(resolve => setTimeout(resolve, ms));
}

let reps=120;

let ppmCurrentText;
let ppmAvgText;
let ppmMaxText;
let ppmMinText;
let ppmStatusContainer;
let ppmStatusText;
let ppmStatusDesc;

let temperatureCurrentText;
let temperatureAvgText;
let temperatureMaxText;
let temperatureMinText;
let temperatureStatusContainer;
let temperatureStatusText;
let temperatureStatusDesc;

let humidityCurrentText;
let humidityAvgText;
let humidityMaxText;
let humidityMinText;
let humidityStatusContainer;
let humidityStatusText;
let humidityStatusDesc;

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
     * 5 = Maximos, minimos y promedios
     */

    if(reps==120){
        reps=0;
        let result = await query(idDevice, key, 5);
        ppmAvgText.textContent = result.ppmAvg;
        ppmMaxText.textContent = result.ppmMax;
        ppmMinText.textContent = result.ppmMin;
        humidityAvgText.textContent = result.humidityAvg;
        humidityMaxText.textContent = result.humidityMax;
        humidityMinText.textContent = result.humidityMin;
        temperatureAvgText.textContent = result.temperatureAvg;
        temperatureMaxText.textContent = result.temperatureMax;
        temperatureMinText.textContent = result.temperatureMin;
    }
    reps++;

    let result = await query(idDevice, key, 0);
    ppmCurrentText.textContent = result.Ppm;
    humidityCurrentText.textContent = result.Humidity;
    temperatureCurrentText.textContent = result.Temperature;

    await sleep(5000); // 2 segundos
    dataReload(idDevice, key);
}

async function setup(idDevice, key){//Maneja los máximos y mínimos, así como el llenado de los arreglos de los distintos datos.
    ppmCurrentText = document.getElementById("ppm-text-holder");
    ppmAvgText = document.getElementById("ppm-text-holder-prom");
    ppmMaxText = document.getElementById("ppm-text-holder-max");
    ppmMinText = document.getElementById("ppm-text-holder-min");
    ppmStatusContainer = document.getElementById("ppm-status-container");
    ppmStatusText = document.getElementById("ppm-status-text-holder");
    ppmStatusDesc = document.getElementById("ppm-status-text-description");

    temperatureCurrentText = document.getElementById("temperature-text-holder");
    temperatureAvgText = document.getElementById("temperature-text-holder-prom");
    temperatureMaxText = document.getElementById("temperature-text-holder-max");
    temperatureMinText = document.getElementById("temperature-text-holder-min");
    temperatureStatusContainer = document.getElementById("temperature-status-container");
    temperatureStatusText = document.getElementById("temperature-status-text-holder");
    temperatureStatusDesc = document.getElementById("temperature-status-text-description");

    humidityCurrentText = document.getElementById("humidity-text-holder");
    humidityAvgText = document.getElementById("humidity-text-holder-prom");
    humidityMaxText = document.getElementById("humidity-text-holder-max");
    humidityMinText = document.getElementById("humidity-text-holder-min");
    humidityStatusContainer = document.getElementById("humidity-status-container");
    humidityStatusText = document.getElementById("humidity-status-text-holder");
    humidityStatusDesc = document.getElementById("humidity-status-text-description");

    dataReload(idDevice, key);
}