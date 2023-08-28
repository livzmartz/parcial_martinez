<h1 class="text-center">Solicitudes de usuario</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioUsuarios">
        <input type="hidden" name="usu_id" id="usu_id">
        <div class="row mb-3">
                <div class="col">
                    <label for="usu_nombre">Nombre del usuario</label>
                    <input type="text" name="usu_nombre" id="usu_nombre" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="usu_usuario">Ingrese su usuario</label>
                    <input type="text" name="usu_usuario" id="usu_usuario" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="usu_password">Ingrese una contraseña</label>
                    <input type="password" name="usu_password" id="usu_password" class="form-control">
                </div>
            </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioUsuarios" id="btnGuardar" data-saludo= "hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
            <div class="col">
                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>
    </form>
</div>
<h1>Datatable de Usuarios</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaUsuarios" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/usuarios/index.js') ?>"></script>