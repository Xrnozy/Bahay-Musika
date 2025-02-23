import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS Files
                "resources/css/app.css",
                "resources/css/carousel.css",
                "resources/css/contacts.css",
                "resources/css/donation.css",
                "resources/css/event.css",
                "resources/css/instruments.css",
                "resources/css/main-css.css",
                "resources/css/scroll.css",

                // JS Files
                "resources/js/antiZoomIn.js",
                "resources/js/app.js",
                "resources/js/bootstrap.js",
                "resources/js/lazyload.js",
            ],
            refresh: true,
        }),
    ],
});
