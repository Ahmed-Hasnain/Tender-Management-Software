require('./bootstrap');
// import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import mitt from 'mitt';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Ondre Ticaret';

// Sweet Alert
window.swal = require('sweetalert2');
window.toast = swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    customClass: {
        title: 'text-xl'
    }
});

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const appVue = createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } });
            appVue.config.globalProperties.swal = window.swal;
            appVue.config.globalProperties.emitter = mitt()
            appVue.mount(el);
    },
});
InertiaProgress.init({ color: '#13E1FE' });
