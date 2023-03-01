
import './bootstrap';
import {createApp} from 'vue';

import router from './router/router';
import App from './components/vuebase.vue';

const app = createApp(App).use(router).mount("#app");