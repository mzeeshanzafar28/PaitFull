import './bootstrap';
import { createApp } from 'vue';
import router from './routes';
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';
import mixins from './mixins';
import './css/app.css';

const basePath = '//127.0.0.1:8000';

const app = createApp(App);
const global = app.config.globalProperties;
global.$apiUrl = `${basePath}/api/`;

app.use(router);
app.use(VueAxios, axios);
app.mixin(mixins);
app.mount('#app');
