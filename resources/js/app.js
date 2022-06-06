require('./bootstrap');

import { createApp } from 'vue';
import CuentaHabiente from './components/CuentaHabiente.vue';
import Sucursales from './components/Sucursales.vue';
import Cuentas from './components/Cuentas.vue';

import Alpine from 'alpinejs';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({});

app.use(VueSweetalert2);

app.component('cuenta-habiente', CuentaHabiente);
app.component('sucursales', Sucursales);
app.component('cuentas', Cuentas);


app.mount('#app');

window.Alpine = Alpine;
Alpine.start();