import Chart from "chart.js/auto";
import { Toast } from "../funciones";

const canvas = document.getElementById('chartUsuariosEstado')
const btnActualizar = document.getElementById('btnActualizar')
const context = canvas.getContext('2d');


const chartUsuariosRol = new Chart(context, {
    type : 'pie',
    data : {
        labels : [],
        datasets : [
            {
                label : 'Cantidad',
                data : [],
                backgroundColor : []
            },
           
        ]
    },
    options : {
        indexAxis : 'y'
    }
})

const getEstadisticas = async () => {
    const url = `/parcial_martinez/API/permisos/estadistica/reporte2`;
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);

        chartUsuariosRol.data.labels = [];
        chartUsuariosRol.data.datasets[0].data = [];
        chartUsuariosRol.data.datasets[0].backgroundColor = []



        if(data){

            data.forEach( registro => {
                console.log(registro);
                chartUsuariosRol.data.labels.push(registro.estado)
                chartUsuariosRol.data.datasets[0].data.push(registro.cantidad_usuarios)
                chartUsuariosRol.data.datasets[0].backgroundColor.push(getRandomColor())
            });

        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
        
        chartUsuariosRol.update();
       
    } catch (error) {
        console.log(error);
    }
}

const getRandomColor = () => {
    const r = Math.floor( Math.random() * 256)
    const g = Math.floor( Math.random() * 256)
    const b = Math.floor( Math.random() * 256)

    const rgbColor = `rgba(${r},${g},${b},0.5)`
    return rgbColor
}

getEstadisticas();

btnActualizar.addEventListener('click', getEstadisticas )