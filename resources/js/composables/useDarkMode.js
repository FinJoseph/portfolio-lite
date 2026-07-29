import { ref, watchEffect } from "vue";

// État partagé au niveau module : un seul état pour toute l'app, pas un état par composant.
// On initialise depuis la classe déjà appliquée sur <html> par le script anti-FOUC de app.blade.php.
const isDark = ref(typeof document !== "undefined" && document.documentElement.classList.contains("dark"));

export function useDarkMode() {
    function toggle() {
        isDark.value = !isDark.value;
    }

    // Synchronise la classe sur <html> et le localStorage à chaque changement.
    watchEffect(() => {
        if (typeof document === "undefined") {
            return;
        }
        document.documentElement.classList.toggle("dark", isDark.value);
        localStorage.setItem("theme", isDark.value ? "dark" : "light");
    });

    return {
        isDark,
        toggle,
    };
}
