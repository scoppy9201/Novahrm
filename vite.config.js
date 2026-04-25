import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "app/packages/Nova/Core/src/resources/css/app.css",
                "app/packages/Nova/Core/src/resources/js/app.js",
            ],
            refresh: [
                ...refreshPaths, 
                "app/Livewire/**",
                "app/packages/**"
            ],
        }),
        tailwindcss(),
    ],
});
