import './bootstrap';
import '../css/app.css'

// Essential
import router from './router'
import store from './store'

// Addons
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import VueParticles from 'vue-particles'

import { createApp } from 'vue'
import App from './App.vue'

const app = createApp(App)

app.config.globalProperties.axios = axios;
app.config.productionTip = false;

// TODO: incorporate permissions
// let permissions = ['access-test', 'access-account', 'view-account'];

app.directive('can', (el, binding) => {
    // let permissions = store.state.auth.permissions; //use a getter
    // if (!permissions.includes(binding.value)) {
    //     console.log(binding.value, '!')
    //     el.style.display = "none"
    // }
})

app.use(router)
    .use(store)
    .use(VueParticles)

app.component('EasyDataTable', Vue3EasyDataTable);

app.mount('#app')
