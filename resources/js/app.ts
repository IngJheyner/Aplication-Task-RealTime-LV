import './bootstrap';

import { createApp } from 'vue';
import App from './src/App.vue';
import router from './src/router/index';

import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

import PrimeVue from 'primevue/config';

import { createPinia } from 'pinia';

import Error from '@/components/Error.vue';
import Input from '@/components/Input.vue';
import Button from '@/components/Button.vue';

const app = createApp(App);

app
.use(router)
.use(ToastPlugin)
.use(PrimeVue, {unstyled: true })
.use(createPinia())
.component('Error', Error)
.component('Input', Input)
.component('Button', Button)
.mount('#app');
