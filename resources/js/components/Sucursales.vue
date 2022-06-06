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
                        SUCURSALES
                    </h4>
                </div>
                <div v-if="guardar || editar">
                    <form @submit.prevent="guardarSucursal()">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="nombre" class="required">Nombre:</label>
                                    <input id="nombre" type="text" name="nombre" v-model="sucursal.nombre" class="form-control" required minlength="3"/>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="direccion" class="required">Dirección:</label>
                                    <input id="direccion" type="text" name="direccion" v-model="sucursal.direccion" class="form-control" required minlength="3"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label for="telefono" class="required">Teléfono:</label>
                                    <input id="telefono" type="number" name="telefono" v-model="sucursal.telefono" class="form-control" required minlength="3"/>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label for="gerente" class="required">Gerente:</label>
                                    <input id="gerente" type="text" name="gerente" v-model="sucursal.gerente" class="form-control" required minlength="3"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group mb-2">
                                    <label for="ciudad" class="required">Ciudad:</label>
                                    <select v-model="sucursal.ciudad_id" name="ciudad" id="ciudad" class="form-control" required minlength="3">
                                        <option disabled selected>Seleccione la ciudad</option>
                                        <option v-for="element in listadoCiudades" :value="element.value" :key="element.value">
                                            {{ element.label }}
                                        </option>
                                    </select>
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
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Gerente</th>
                                        <th>Ciudad</th>
                                        <th>Fecha Creado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(elemento, i) in listadoSucursales" :key="i">
                                        <td>{{ elemento.nombre}}</td>
                                        <td>{{ elemento.direccion}}</td>
                                        <td>{{ elemento.telefono }}</td>
                                        <td>{{ elemento.gerente }}</td>
                                        <td>{{ elemento.ciudad.nombre }}</td>
                                        <td>{{ fecha(elemento.created_at) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info mr-2" v-on:click="editarSucursal(elemento)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" v-on:click="eliminarSucursal(elemento.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
            sucursal: {
                id: null,
                nombre: '',
                direccion: '',
                telefono: '',
                gerente: '',
                ciudad_id: null
            },
            listadoCiudades: [],
            listadoSucursales: []
        }
    },
    methods: {
        limpiarCampos() {
            this.sucursal = {
                id: null,
                nombre: '',
                direccion: '',
                telefono: '',
                gerente: '',
                ciudad_id: null
            };
        },
        fecha: function(value) {
            return moment().format("YYYY-MM-DD HH:mm:ss");
        },
        async listarCiudades() {
            await axios.get('../usuarios/ciudades/obtener').then(res => {
                this.listadoCiudades = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        async listarSucursales() {
            await axios.get('../sucursales').then(res => {
                this.listadoSucursales = res.data;
            }).catch(err => {
                console.log(err);
            });
        },
        //
        editarSucursal(element) {
            this.editar = true;
            this.guardar = false;
            this.sucursal = {
                id: element.id,
                nombre: element.nombre,
                direccion: element.direccion,
                telefono: element.telefono,
                gerente: element.gerente,
                ciudad_id: element.ciudad_id
            };
        },
        guardarSucursal() {
            if(this.sucursal.id == null) {
                //guardar
                this.$swal({
                title: `¿Está seguro de guardar la sucursal?`,
                type: "warning",
                text: `Guardar ${ this.sucursal.nombre }`,
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
                title: `¿Está seguro de editar la sucursal?`,
                type: "warning",
                text: `Editar a ${ this.sucursal.nombre }`,
                showCancelButton: true,
                confirmButtonText: "Si, Confirmar",
                cancelButtonText: "No, Cancelar",
                buttonsStyling: true
                }).then(result => {
                    try {
                        if (result) {
                            this.editSucursal();
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
            this.$swal.showLoading();
            await axios
                .post("../sucursales/", this.sucursal).then(response => {
                    if (response) {
                        this.callSwal(
                            "Operación exitosa",
                            "Sucursal almacenada con éxito",
                            "success",
                            true
                        );
                        this.guardar = false;
                        this.listarSucursales();
                        this.limpiarCampos();
                    }
                    else {
                        this.callSwal(
                            "Ocurrio un error",
                            "No se ha podido almacenar la sucursal",
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
        async editSucursal() {
            await axios
                .put('../sucursales/' + this.sucursal.id, this.sucursal).then(response => {
                    if (response) {
                        this.callSwal(
                            "Operación exitosa",
                            "Sucursal editada con éxito",
                            "success",
                            true
                        );
                        this.editar = false;
                        this.listarSucursales();
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
        eliminarSucursal(id) {
            this.$swal({
                title: `¿Está seguro de eliminar la sucursal?`,
                type: "warning",
                text: `Eliminar sucursal del sistema`,
                showCancelButton: true,
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                buttonsStyling: true
                }).then(result => {
                try {
                    if (result) {
                        this.deleteSucursal(id);
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
        async deleteSucursal(id) {
            await axios
                .delete('../sucursales/' + id).then(result => {
                    if (result) {
                        this.callSwal(
                            "Operación exitosa",
                            "Sucursal eliminada con éxito",
                            "success",
                            true
                        );
                        this.listarSucursales();
                    }
                    else {
                        this.callSwal(
                            "Ocurrio un error",
                            "No se ha podido eliminar la sucursal",
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
    }
}
</script>
<style>

</style>
