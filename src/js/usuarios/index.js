import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";
import { lenguaje } from "../lenguaje";
import Datatable from "datatables.net-bs5";

const formulario = document.querySelector('form')
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('#tablaUsuarios');

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'
btnBuscar.disabled = true;
btnBuscar.parentElement.style.display = 'none';

let contador = 1; 
const datatable = new Datatable('#tablaUsuarios', {
    language : lenguaje,
    data : null,
    columns: [
        {
            title : 'NO',
            render : () => contador ++
            
        },
        {
            title : 'NOMBRE',
            data: 'usu_nombre'
        },
        {
            title : 'USUARIO',
            data: 'usu_usuario',
        },
        {
            title : 'CONTRASEÑA',
            data: 'usu_password',
        },
        {
            title : 'ESTADO',
            data: 'usu_estado',
        },
        {
            title : 'MODIFICAR',
            data: 'usu_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["usu_nombre"]}' 
            data-usuario='${row["usu_usuario"]}' data-password='${row["usu_password"]}'>Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'usu_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },

    ]
})

const buscar = async () => {
    let usu_nombre = formulario.usu_nombre.value;
    let usu_usuario = formulario.usu_usuario.value;
    let usu_password = formulario.usu_password.value;
    
    const url = `/parcial_martinez/API/usuarios/buscar?usu_nombre=${usu_nombre}&usu_usuario=${usu_usuario}&usu_password=${usu_password}`;
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        // console.log(data);
        datatable.clear().draw()
        if(data){
            contador = 1;
            datatable.rows.add(data).draw();
        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
       
    } catch (error) {
        console.log(error);
    }
}

const guardar = async (evento) => {
    evento.preventDefault();

    if(!validarFormulario(formulario, ['usu_id'])){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return;
    }

    const body = new FormData(formulario)
    body.delete('usu_id')

    const url = '/parcial_martinez/API/usuarios/guardar';
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method : 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

       
        const {codigo, mensaje,detalle} = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;
        
            case 0:
                icon = 'error'
                console.log(detalle)
                break;
        
            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;

    if (await confirmacion('warning', '¿Desea eliminar este registro?')) {
        const body = new FormData();
        body.append('usu_id', id);
        const url = '/parcial_martinez/API/usuarios/eliminar';
        const config = {
            method: 'POST',
            body
        };

        try {
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            const { codigo, mensaje, detalle } = data;
            let icon = 'info';
            switch (codigo) {
                case 1:
                    icon = 'success';
                    buscar();
                    break;

                case 0:
                    icon = 'error';
                    console.log(detalle);
                    break;

                default:
                    break;
            }
            Toast.fire({
                icon,
                text: mensaje
            });
        } catch (error) {
            console.log(error);
        }
    }
};

const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
    divTabla.style.display = ''
}

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const usuario = button.dataset.usuario;
    const password = button.dataset.password;

    const dataset = {
        id,
        nombre,
        usuario,
        password
    };

    colocarDatos(dataset);
        const body = new FormData(formulario);
        body.append('usu_id', id);
        body.append('usu_nombre', nombre);
        body.append('usu_usuario', usuario);
        body.append('usu_password', password);  

};

const colocarDatos = (dataset) => {
    formulario.usu_nombre.value = dataset.nombre;
    formulario.usu_usuario.value = dataset.usuario;
    formulario.usu_password.value = dataset.password;
    formulario.usu_id.value = dataset.id;
    
    btnGuardar.disabled = true;
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';
    
    btnModificar.disabled = false;
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false;
    btnCancelar.parentElement.style.display = '';
    
    // divTabla.style.display = 'none';
};


const modificar = async () => {
  
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }
    const body = new FormData(formulario)
   
    const url = '/parcial_martinez/API/usuarios/modificar';
    const headers = new Headers();

    headers.append("X-Requested-With","fetch");
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        console.log(data);
        //    return;

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                Toast.fire({
                    icon: 'success',
                    text: mensaje
                })
                buscar();
                cancelarAccion();
                break;

            case 0:
                Toast.fire({
                    icon: 'error',
                    text: mensaje
                })
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}


buscar();

// console.log(formulario);
formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )