function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

let a=5;
let temperature=document.getElementById("temperatureHolder");

async function dataReload(){
    temperature.textContent=a;
    a+=1;
    await sleep(1000);
    dataReload();
}

dataReload();