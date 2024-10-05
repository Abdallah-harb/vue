import { createApp } from 'vue'
//import './style.css'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import vuetify from './plugins/vuetify';
import App from './App.vue'
import router from './router';
import {createPinia} from "pinia";

const app = createApp(App);
app.use(router)
    .use(createPinia())
    .use(vuetify)
    .mount('#app')
