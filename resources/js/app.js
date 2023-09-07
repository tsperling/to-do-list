import './bootstrap';

import { createApp } from 'vue';

window.createApp = createApp;

import App from '../components/TaskApp.vue';

createApp(App).mount("#taskApp");
