import { createApp } from 'vue';

import './assets/main.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import "font-awesome/css/font-awesome.min.css";
import "../node_modules/nprogress/nprogress.css";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import "sweetalert2/dist/sweetalert2.min.css";
import VueSweetalert2 from "vue-sweetalert2";
import App from './App.vue'
import router from './router'
import Store from "./store/Store";

const app = createApp(App)

app.use(router)
app.use(Store);
app.use(VueSweetalert2);

app.config.devtools = true;
app.mount('#app')
