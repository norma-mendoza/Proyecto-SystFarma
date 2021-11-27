/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('categoria', require('./components/Categoria.vue').default);
Vue.component('presentacion', require('./components/Presentacion.vue').default);
Vue.component('laboratorio', require('./components/Laboratorio.vue').default);
Vue.component('proveedor', require('./components/Proveedor.vue').default);
Vue.component('producto', require('./components/Producto.vue').default);
Vue.component('cliente', require('./components/Cliente.vue').default);
Vue.component('rol', require('./components/Rol.vue').default);
Vue.component('empleado', require('./components/Empleado.vue').default);
Vue.component('user', require('./components/User.vue').default);
Vue.component('ingreso', require('./components/Ingreso.vue').default);
Vue.component('venta', require('./components/Venta.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/es';//cambia el idioma 
Vue.use(ElementUI, { locale });
Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    data:{
        menu : 0,
        render: h => h(App)

    }
    
});
