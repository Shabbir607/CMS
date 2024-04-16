import { createApp } from 'vue';
import App from './App.vue';
import router from './routes';
import './configAuth/baseUrl';
// import { createPinia } from 'pinia';
window.$ = window.jQuery = require("jquery");


const app = createApp(App);
  app.use(router);
  app.use(App);
  // app.use(createPinia());
 app .mount('#app');
