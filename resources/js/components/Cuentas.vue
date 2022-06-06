<template>
    <div>
        <div class="col-md-12">
            <div class="card text-left mb-4">
                <div class="card-header">
                    <h4 class="card-title text-center">
                        Mi cuenta
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Cuenta no {{ cuenta.numero_cuenta }}</h5>
                                </div>
                                <div class="card-body">
                                    Saldo: ${{ cuenta.saldo }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Movimientos</h5>
                                </div>
                                <div class="card-body">
                                    <form @submit.prevent="realizarMovimiento()">
                                        <h6>Consignar</h6>
                                        <div class="form-group">
                                            <input type="number" required class="form-control" min="10000" v-model="consignacion">
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" v-on:click="movimiento.tipo_id = 1" class="btn btn-primary">Consignar</button>
                                        </div>
                                        <hr>
                                    </form>
                                    <form @submit.prevent="realizarMovimiento()">
                                        <h6>Retirar</h6>
                                        <div class="form-group">
                                            <input type="number" required class="form-control" min="10000" v-model="retiro">
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" v-on:click="movimiento.tipo_id = 2" class="btn btn-success">Retirar</button>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => {
        return {
            cuenta: {
                id: null,
                numero_cuenta: '',
                saldo: null,
                user_id: null
            },
            consignacion: null,
            retiro: null,
            movimiento: {
                tipo_id: null,
                detalle: null,
                fecha: null
            },
        }
    },
    methods: {
        realizarMovimiento() {
            var titulo = '';
            if (this.movimiento.tipo_id == 1) {
                titulo = 'Consignar';
                this.movimiento.detalle = this.consignacion;
            }
            else {
                titulo = 'Retirar';
                this.movimiento.detalle = this.retiro;
            }

            this.$swal({
                title: `¿Está seguro de realizar el movimiento?`,
                type: "warning",
                text: `${titulo}`,
                showCancelButton: true,
                confirmButtonText: "Si, Confirmar",
                cancelButtonText: "No, Cancelar",
                buttonsStyling: true
                }).then(result => {
                    try {
                        if (result) {
                            if (!this.validaciones()) {
                                this.movimiento.fecha = new Date();
                                this.save();
                            }
                            else {
                                this.callSwal(
                                    "¡Error!",
                                    "El saldo de la cuenta no es suficiente para el retiro",
                                    "error",
                                    true
                                );
                            }
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
        validaciones() {
            if (this.movimiento.tipo_id == 2) {
                if (this.movimiento.detalle > this.cuenta.saldo) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        },
        save() {
            axios.put('../cuentas/' + this.cuenta.id, this.movimiento).then(response => {
                if (response) {
                    this.callSwal(
                        "Operación exitosa",
                        "Movimiento realizado con éxito",
                        "success",
                        true
                    );
                    this.obtenerCuenta();
                    this.limpiarCampos();
                }
                else {
                    this.callSwal(
                        "Ocurrio un error",
                        "No se ha podido realizar el movimiento",
                        "error",
                        true
                    );
                }
            }).catch(err => {
                console.log(err);
            });
        },
        limpiarCampos() {
            this.movimiento = {
                tipo_id: null,
                detalle: null,
                fecha: null
            };
            this.consignacion = null;
            this.retiro = null;
        },
        async obtenerCuenta() {
            await axios.get('../cuentas').then(res => {
                console.log(res.data);
                this.cuenta = res.data;
            }).catch(err => {
                console.log(err);
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
        this.obtenerCuenta();
    }
}
</script>
<style>

</style>
