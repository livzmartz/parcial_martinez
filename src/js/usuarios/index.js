import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion} from "../funciones";
import { lenguaje  } from "../lenguaje";


const formulario = document.querySelector('form')
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

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
            title : 'CATALOGO',
            data: 'usu_catalogo',
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
            data-catalogo='${row["usu_catalogo"]}' data-password='${row["usu_password"]}'>Modificar</button>`
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
    let usu_catalogo = formulario.usu_catalogo.value;
    let usu_password = formulario.usu_password.value;
    
    const url = `/parcial_martinez/API/usuarios/buscar?usu_nombre=${usu_nombre}&usu_catalogo=${usu_catalogo}&usu_password=${usu_password}`;
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
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
        return 
    }

    const body = new FormData(formulario)
    body.delete('usu_id')

    const plainPassword = body.get('usu_password');
    const hashedPassword = await bcrypt.hash(plainPassword, 10); 

    // Utiliza la contraseña hasheada en lugar de la ingresada por el usuario
    body.set('usu_password', hashedPassword);

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

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const nombre = button.dataset.nombre;
    const catalogo = button.dataset.catalogo;
    const password = button.dataset.password;
    

    const dataset = {
        id,
        nombre,
        catalogo,
        password
    };
    colocarDatos(dataset);
        const body = new FormData(formulario);
        body.append('usu_id', id);
        body.append('usu_nombre', nombre);
        body.append('usu_catalogo', catalogo);
        body.append('usu_password', password);  

};



buscar();

formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )