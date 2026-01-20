import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { VueGoodTable } from 'vue-good-table-next';
import { router } from '@inertiajs/vue3';

// Import DataTable styles
import 'vue-good-table-next/dist/vue-good-table-next.css'

createInertiaApp({
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });
    app.use(plugin);
    
    // Register VueGoodTable globally
    app.component('vue-good-table', VueGoodTable);
    
    app.mount(el);
  },
  progress: {
    color: '#4D9F95',
  },
});
