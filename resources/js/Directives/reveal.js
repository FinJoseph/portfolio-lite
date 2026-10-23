/**
 * v-reveal — révélation douce au scroll.
 *
 * Amélioration progressive : le contenu est visible par défaut. La directive
 * ne masque QUE les éléments encore sous la ligne de flottaison au montage,
 * puis un IntersectionObserver partagé les révèle à l'entrée dans le viewport.
 *
 * Usage :
 *   <div v-reveal>…</div>
 *   <article v-for="(p, i) in items" v-reveal="{ delay: i * 60 }">…</article>
 *
 * Ne fait rien si `prefers-reduced-motion: reduce` (le contenu reste visible).
 */

let observer = null;

function getObserver() {
    if (observer) {
        return observer;
    }

    observer = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) {
                    continue;
                }

                entry.target.classList.add('is-revealed');
                observer.unobserve(entry.target);
            }
        },
        // Déclenche un peu avant le bord bas pour que l'élément soit déjà
        // en place quand il entre réellement à l'écran.
        { rootMargin: "0px 0px -8% 0px", threshold: 0.01 }
    );

    return observer;
}

export default {
    mounted(el, binding) {
        const reduceMotion = window.matchMedia(
            "(prefers-reduced-motion: reduce)"
        ).matches;

        if (reduceMotion || !("IntersectionObserver" in window)) {
            return;
        }

        const delay = Number(binding.value?.delay ?? 0);

        if (delay > 0) {
            el.style.setProperty("--reveal-delay", `${Math.min(delay, 400)}ms`);
        }

        // Élément déjà visible (ou juste au-dessus de la ligne de flottaison) :
        // on ne le masque pas, sinon il « clignote » au premier rendu.
        const { top } = el.getBoundingClientRect();

        if (top < window.innerHeight * 0.92) {
            return;
        }

        el.setAttribute("data-reveal", "");
        getObserver().observe(el);
    },

    unmounted(el) {
        observer?.unobserve(el);
        el.removeAttribute("data-reveal");
    },
};
