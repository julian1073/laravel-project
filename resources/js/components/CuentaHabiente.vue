<template>
    <div>
        <div class="col-md-12">
            <div class="card text-left mb-4">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col text-right">
                            <button v-if="guardar"
                                type="button"
                                @click="guardar = false"
                                class="btn btn-danger text-left"
                            >
                                <i class="fas fa-arrow-circle-left"></i>
                                Regresar
                            </button>
                            <button v-if="!guardar"
                                type="button"
                                @click="limpiarCampos(); guardar = true"
                                class="btn btn-success text-left"
                            >
                                <i class="fas fa-plus"></i>
                                Nuevo
                            </button>
                        </div>
                    </div>
                    <h4 class="card-title text-center">
                        CUENTAHABIENTES
                    </h4>
                </div>
                <div v-if="guardar || editar">
                    <form @submit.prevent="guardarUser()">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="name" class="required">Nombre:</label>
                                    <input id="name" type="text" name="name" v-model="user.name" class="form-control" required minlength="3"/>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="apellidos" class="required">Apellidos:</label>
                                    <input id="apellidos" type="text" name="apellidos" v-model="user.apellidos" class="form-control" required minlength="3"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="numero_identificacion" class="required">Número de identificación:</label>
                                    <input id="numero_identificacion" type="number" name="numero_identificacion" v-model="user.numero_identificacion" class="form-control" required minlength="3"/>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="direccion" class="required">Dirección:</label>
                                    <input id="direccion" type="text" name="direccion" v-model="user.direccion" class="form-control" required minlength="3"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="ciudad" class="required">Ciudad:</label>
                                    <select v-model="user.ciudad_id" name="ciudad" id="ciudad" class="form-control" required minlength="3">
                                        <option disabled selected>Seleccione la ciudad</option>
                                        <option v-for="element in listadoCiudades" :value="element.value" :key="element.value">
                                            {{ element.label }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="sucursal" class="required">Sucursal:</label>
                                    <select v-model="user.sucursal_id" name="sucursal" id="sucursal" class="form-control" required minlength="3">
                                        <option disabled selected>Seleccione la sucursal</option>
                                        <option v-for="element in listadoSucursales" :value="element.value" :key="element.value">
                                            {{ element.label }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="guardar" class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="email" class="required">Email:</label>
                                    <input id="email" type="email" name="email" v-model="user.email" class="form-control" required minlength="3"/>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="password" class="required">Contraseña:</label>
                                    <input id="password" type="password" name="password" v-model="user.password" class="form-control" required minlength="3"/>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="row text-center">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <span v-if="guardar">
                                            Guardar
                                        </span>
                                        <span v-if="editar">
                                            Editar
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div v-if="!guardar && !editar">
                    <div class="row form-group justify-content-center">
                        <div class="col-sm-12">
                            <table
                                class="m-4 table text-center table-striped table-bordered table-hover"
                                style="width:95%">
                                <thead>
                                    <tr class="hover">
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Email</th>
                                        <th>Número de Identificación</th>
                                        <th>Dirección</th>
                                        <th>Ciudad</th>
                                        <th>Sucursal</th>
                                        <th>Fecha Creado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(elemento, i) in listadoUsuarios" :key="i">
                                        <td>{{ elemento.name}}</td>
                                        <td>{{ elemento.apellidos }}</td>
                                        <td>{{ elemento.email }}</td>
                                        <td>{{ elemento.numero_identificacion }}</td>
                                        <td>{{ elemento.direccion}}</td>
                                        <td>{{ elemento.ciudad.nombre }}</td>
                                        <td>{{ elemento.sucursal.nombre }}</td>
                                        <td>{{ fecha(elemento.created_at) }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <button class="btn btn-sm btn-info mb-2" v-on:click="editarUsuario(elemento)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col">
                                                    <button class="btn btn-sm btn-danger" v-on:click="eliminarUsuario(elemento.id)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
export default {
    data: () => {
        return {
            guardar: false,
            editar: false,
            user: {
                id: null,
                name: '',
                email: '',
                password: '',
                rol: null,
                apellidos: '',
                numero_identificacion: '',
                direccion: '',
                ciudad_id: null,
                sucursal_id: null,
                rol: 3
            },
            listadoCiudades: [],
            listadoSucursales: [],
            listadoUsuarios: []
        }
    },
    methods: {
        limpiarCampos() {
            this.user = {
                id: null,
                name: '',
                email: '',
                password: '',
                rol: null,
                apellidos: '',
                numero_identificacion: '',
                direccion: '',
                ciudad_id: null,
                sucursal_id: null,
                rol: 3
            };
        },
        fecha: function(value) {
            return moment().format("YYYY-MM-DD HH:mm:ss");
        },
        async listarCiudades() {
            await axios.get('ciudades/obtener').then(res => {
                this.listadoCiudades = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        async listarSucursales() {
            await axios.get('sucursales/obtener').then(res => {
                this.listadoSucursales = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        async listarUsuarios() {
            await axios.get('../usuarios').then(res => {
                console.log(res.data);
                this.listadoUsuarios = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        editarUsuario(element) {
            this.editar = true;
            this.guardar = false;
            this.user = {
                id: element.id,
                name: element.name,
                email: element.email,
                password: element.password,
                rol: 3,
                apellidos: element.apellidos,
                numero_identificacion: element.numero_identificacion,
                direccion: element.direccion,
                ciudad_id: element.ciudad_id,
                sucursal_id: element.sucursal_id,
            };
        },
        guardarUser() {
            if(this.user.id == null) {
                //guardar
                this.$swal({
                title: `¿Está seguro de guardar el usuario?`,
                type: "warning",
                text: `Guardar a ${ this.user.name }`,
                showCancelButton: true,
                confirmButtonText: "Si, Confirmar",
                cancelButtonText: "No, Cancelar",
                buttonsStyling: true
                }).then(result => {
                    try {
                        if (result) {
                            this.save();
                        }
                    } catch (err) {
                        console.log(err);
                        this.callSwal(
                            "¡Error!",
                            "Ha ocurrido un error",
                            "error",
                            true
                        );
                    }
                });
            }
            else {
                //Editar
                this.$swal({
                title: `¿Está seguro de editar el usuario?`,
                type: "warning",
                text: `Editar a ${ this.user.name }`,
                showCancelButton: true,
                confirmButtonText: "Si, Confirmar",
                cancelButtonText: "No, Cancelar",
                buttonsStyling: true
                }).then(result => {
                    try {
                        if (result) {
                            this.editUser();
                        }
                    } catch (err) {
                        console.log(err);
                        this.callSwal(
                            "¡Error!",
                            "Ha ocurrido un error",
                            "error",
                            true
                        );
                    }
                });
            }
        },
        async save() {
            this.user.numero_identificacion = this.user.numero_identificacion.toString();
            this.$swal.showLoading();
            console.log(this.user);
            await axios
                .post("../usuarios/", this.user).then(response => {
                    console.log(response.data);
                    if (response.data == 1) {
                        this.callSwal(
                            "Operación exitosa",
                            "Usuario almacenado con éxito",
                            "success",
                            true
                        );
                        this.guardar = false;
                        this.listarUsuarios();
                        this.limpiarCampos();
                    } else if (response.data == 0) {
                        this.callSwal(
                            "Ocurrio un error",
                            "El email ya se encuentra registrado",
                            "error",
                            true
                        );
                    }
                    else {
                        this.callSwal(
                            "Ocurrio un error",
                            "No se ha podido almacenar el usuario",
                            "error",
                            true
                        );
                    }
                })
                .catch(err => {
                    console.log(err);
                    this.callSwal("¡Error!", "Ha ocurrido un error", "error", true);
                });
        },
        async editUser() {
            await axios
                .put('../usuarios/' + this.user.id, this.user).then(response => {
                    if (response) {
                        this.callSwal(
                            "Operación exitosa",
                            "Usuario editado con éxito",
                            "success",
                            true
                        );
                        this.editar = false;
                        this.listarUsuarios();
                        this.limpiarCampos();
                    }
                    else {
                        this.callSwal(
                            "Ocurrio un error",
                            "No se ha podido editar el usuario",
                            "error",
                            true
                        );
                    }
                })
                .catch(err => {
                    console.log(err);
                    this.callSwal("¡Error!", "Ha ocurrido un error", "error", true);
                });
        },
        eliminarUsuario(id) {
            this.$swal({
                title: `¿Está seguro de eliminar el usuario?`,
                type: "warning",
                text: `Eliminar usuario del sistema`,
                showCancelButton: true,
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                buttonsStyling: true
                }).then(result => {
                try {
                    if (result) {
                        this.deleteUser(id);
                    }
                } catch (err) {
                    console.log(err);
                    this.callSwal(
                        "¡Error!",
                        "Ha ocurrido un error",
                        "error",
                        true
                    );
                }
            });
        },
        async deleteUser(id) {
            await axios
                .delete('../usuarios/' + id).then(result => {
                    if (result) {
                        this.callSwal(
                            "Operación exitosa",
                            "Usuario eliminado con éxito",
                            "success",
                            true
                        );
                        this.listarUsuarios();
                    }
                    else {
                        this.callSwal(
                            "Ocurrio un error",
                            "No se ha podido almacenar el usuario",
                            "error",
                            true
                        );
                    }
                })
                .catch(err => {
                    console.log(err);
                    this.callSwal("¡Error!", "Ha ocurrido un error", "error", true);
                });
        },
        callSwal(titulo, texto, tipo, boton) {
            this.$swal({
                type: tipo,
                title: titulo,
                text: texto,
                confirmButtonText: "Cerrar",
                showConfirmButton: boton,
                confirmButtonClass: "btn btn-lg btn-primary",
                allowEscapeKey: false,
                allowOutsideClick: false
            });
        },
        loadedSwall(texto) {
            this.$swal({
                title:
                    "<span class='spinner-glow spinner-glow-primary mt-3'></span>",
                text: texto,
                confirmButtonText: "Cerrar",
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false
            });
        },
    },
    created() {
        this.listarCiudades();
        this.listarSucursales();
        this.listarUsuarios();
    }
}
</script>
<style>
.required:after {
    content: " *";
    color: red;
}
</style>
