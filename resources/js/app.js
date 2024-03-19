import './bootstrap.js';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import NProgress from 'nprogress'
router.on('start', () => NProgress.start())
router.on('finish', () => NProgress.done())
createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .mixin({methods: {route}})
            .mount(el)
    },
}).then(r =>console.log('welcome'))
