import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, usePage } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// Toast notifications
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

createInertiaApp({
    title: (title) => `${title} - ${usePage().props.appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(Toast, {
            position: "top-right",
            timeout: 5000,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 0.6,
            showCloseButtonOnHover: false,
            hideProgressBar: false,
            closeButton: "button",
            icon: true,
            rtl: false,
        });

        app.mount(el);
    },
    progress: {
        color: "#6771cf",
    },
});
