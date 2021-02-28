import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

// https://stackoverflow.com/a/64273694/4096078
createApp(App, { ...window })
.use(VueAxios, axios)
.mount("#app");