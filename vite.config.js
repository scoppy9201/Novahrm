import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "packages/Nova/Core/src/resources/css/app.css",
                "packages/Nova/Core/src/resources/js/app.js",
                "packages/Nova/Auth/src/resources/css/app.css",
                "packages/Nova/Auth/src/resources/js/app.js",
                "packages/Nova/Dashboard/src/resources/css/app.css",
                "packages/Nova/Dashboard/src/resources/js/app.js",
                "packages/Nova/Profile/src/resources/css/app.css",
                "packages/Nova/Profile/src/resources/js/app.js",
            ],
            refresh: [
                ...refreshPaths,
                "app/Livewire/**",
                "packages/**",
            ],
        }),
        tailwindcss(),
    ],
});