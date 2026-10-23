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
                bunny("Instrument Serif", {
                    weights: [400], // serif d'affichage : accents éditoriaux (tagline hero, chiffres clés)
                    styles: ["normal", "italic"], // italique inclus : utilisé pour les accents en serif
                }),
                bunny("JetBrains Mono", {
                    weights: [400, 500], // eyebrows, badges, blocs de code (Shiki en S4)
                }),
            ],
        }),
        tailwindcss(), // plugin officiel Tailwind v4 : scanne le code et génère uniquement le CSS utilisé
        vue(), // AJOUT : active la compilation des Single File Components (.vue) → template + script + style
    ],
    build: {
        rollupOptions: {
            output: {
                // Découpe les dépendances en chunks séparés (API Rolldown / Vite 8) :
                // le vendor reste mis en cache entre deux versions du site, et les
                // chunks de pages sont chargés en parallèle au premier affichage.
                advancedChunks: {
                    groups: [
                        {
                            name: "vendor-vue",
                            test: /node_modules[\\/](@vue[\\/]|vue[\\/]|vue-i18n[\\/]|@intlify[\\/])/,
                        },
                        {
                            name: "vendor-inertia",
                            test: /node_modules[\\/]@inertiajs[\\/]/,
                        },
                    ],
                },
            },
        },
    },
    server: {
        host: '127.0.0.1',
        cors: true,
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
