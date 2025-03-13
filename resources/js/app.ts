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

import { Bootstrap5Pagination } from "laravel-vue-pagination";

import VueApexCharts from 'vue3-apexcharts';

const app = createApp(App);

app
.use(router)
.use(ToastPlugin)
.use(PrimeVue, {unstyled: true })
.use(createPinia())
.use(VueApexCharts)
.component('Error', Error)
.component('Input', Input)
.component('Button', Button)
.component('Bootstrap5Pagination',Bootstrap5Pagination)
.mount('#app');
