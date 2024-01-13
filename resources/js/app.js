import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import router from './router';
import App from "./App.vue";
import { RouterLink } from 'vue-router';

const app = createApp(App);

app.use(router);
app.component(RouterLink);

app.mount("#app");
