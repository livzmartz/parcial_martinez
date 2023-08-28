import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const formulario = document.querySelector('form');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const divUsuario = document.getElementById('permiso_usuario');
const divRol = document.getElementById('permiso_rol');
// divUsuario.parentElement.style.display = 'blcok';
// divRol.parentElement.style.display = ' block';


btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

let contador = 1;
const datatable = new DataTable('#tablaPermisos', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'USUARIO',
            data: 'permiso_usuario'
        },
        {
            title: 'PERMISO',
            data: 'permiso_rol'
        },
        {
            title: 'ESTADO',
            data: 'usu_estado'
        },
        {
            title : 'MODIFICAR',
            data: 'permiso_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) =>`<button class="btn btn-warning" data-id='${data}' data-usuario='${row["usu_id"]}'
            data-rol='${row["rol_id"]}'>Modificar</button>`

        },
        {
            title: 'ELIMINAR',
            data: 'permiso_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
    ]
});

const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['permiso_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.delete('permiso_id');
    const url = '/parcial_martinez/API/permisos/guardar';
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
                formulario.reset();
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
};

const buscar = async () => {
    let permiso_usuario = formulario.permiso_usuario.value;
    let permiso_rol = formulario.permiso_rol.value;
    const url = `/parcial_martinez/API/permisos/buscar?permiso_usuario=${permiso_usuario}&permiso_rol=${permiso_rol}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        // console.log(data)
        datatable.clear().draw();
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }
}

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
    console.log(button);
    const id = button.dataset.id;
    const usuario = button.dataset.usuario;
    const rol = button.dataset.rol;

    // console.log(id);
    // console.log(usuario);
    // console.log(rol);




    const dataset = {
        id,
        usuario,
        rol
    };

    console.log(dataset)
    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('permiso_id', id);
    body.append('permiso_usuario', usuario);
    body.append('permiso_rol', rol);

};
const colocarDatos = (dataset) => {

    formulario.permiso_usuario.value = dataset.usuario;
    formulario.permiso_rol.value = dataset.rol;
    formulario.permiso_id.value = dataset.id;
   

    // divPassword.parentElement.style.display = ' block';
    // divUsuario.parentElement.style.display = 'none';
    // divRol.parentElement.style.display = 'none';
    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = '';


}

const modificar = async () => {
    if (!validarFormulario(formulario)) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos'
        });
        return;
    }

    const body = new FormData(formulario)
    const url = 'parcial_martinez/API/permisos/modificar';
    const config = {
        method: 'POST',
        body
    }
    for (var pair of body.entries()) {
        console.log('"'+pair[0]+ '", "' + pair[1]+'"'); 
    }
    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        console.log(data)
        const { codigo, mensaje, detalle } = data;
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
        body.append('permiso_id', id);
        const url = '/parcial_martinez/API/permisos/eliminar';
        const config = {
            method: 'POST',
            body
        };


        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            console.log(data)
            const { codigo, mensaje, detalle } = data;
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
}


buscar()
formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )