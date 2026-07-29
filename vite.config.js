import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { bunny } from "laravel-vite-plugin/fonts";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue"; // AJOUT : permet à Vite de comprendre les fichiers .vue (compilation en JS)

export default defineConfig({
    plugins: [
        laravel({
            // Les 2 fichiers "point d'entrée" que Vite doit compiler et injecter dans le HTML
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true, // recharge automatiquement le navigateur quand un fichier PHP/Blade change (hot reload dev)
            fonts: [
                bunny("Instrument Sans", {
                    weights: [400, 500, 600], // charge la police via Bunny Fonts (alternative RGPD-friendly à Google Fonts)
                }),
            ],
        }),
        tailwindcss(), // plugin officiel Tailwind v4 : scanne le code et génère uniquement le CSS utilisé
        vue(), // AJOUT : active la compilation des Single File Components (.vue) → template + script + style
    ],
    server: {
        host: '127.0.0.1',
        cors: true,
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
