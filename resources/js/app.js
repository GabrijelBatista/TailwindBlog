import {createApp} from 'vue'

require('./bootstrap')
import App from './App.vue'
import axios from 'axios'
import router from './router'
import store from "./store"
import Toaster from '@meforma/vue-toaster'
import VueSocialSharing from 'vue-social-sharing'

const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.use(router)
app.use(Toaster)
app.use(store)
app.use(VueSocialSharing)
app.mount('#app')
