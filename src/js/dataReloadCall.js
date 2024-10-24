function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

let a=5;
let temperature=document.getElementById("temperatureHolder");

async function dataReload() {

    try {
        const response = await fetch('IoT/getLastRow.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (data.error) {
            console.error(data.error);
        } else {
            console.log(data);
            temperatureHolder.textContent = data.datatest + " " + a; 
        }
    } catch (error) {
        console.error('Error al obtener los datos:', error);
    }

    a+=1;

    await sleep(5000); // 5 segundos
    dataReload();
}

dataReload();