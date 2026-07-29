import { createI18n } from "vue-i18n";
import fr from "./locales/fr.json";
import en from "./locales/en.json";
import mg from "./locales/mg.json";
// La locale initiale vient du serveur (Inertia partage `locale` via HandleInertiaRequests),
// donc le composant racine la configure au montage — voir app.js.
export const i18n = createI18n({
    legacy: false, // requis pour utiliser useI18n() avec Composition API
    locale: "fr",
    fallbackLocale: "fr",
    messages: {
        fr,
        en,
        mg,
    },
});
