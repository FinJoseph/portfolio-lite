<script setup>
/*
 * CyberGrid — fond « cyberpunk / tech avancé » 100% SVG + CSS, zéro JS.
 *
 * Composition :
 *  1. Une grille SVG plein écran (cellules 48×48) avec petits points lumineux
 *     aux intersections — donne le côté « circuit board / terminal ».
 *  2. Deux halos verts d'ambiance, positionnés en diagonale, avec une
 *     opacité légèrement plus marquée qu'avant et une animation de
 *     pulsation désynchronisée pour donner de la vie au fond sans
 *     distraire du contenu.
 *
 * Light / Dark :
 *  - Pas de @media (prefers-color-scheme) ni de JS pour détecter le mode :
 *    on s'appuie sur la classe .dark que useDarkMode pose déjà sur <html>.
 *    Tailwind traduit ça automatiquement avec les variants dark:.
 *  - Opacité plus marquée en sombre qu'en clair.
 *
 * Perf :
 *  - Aucun canvas, aucune animation JS, aucun listener d'événement.
 *  - Les halos sont de simples divs floutées via CSS filter.
 *  - Les animations utilisent uniquement opacity et transform (GPU-friendly).
 */
</script>

<template>
    <div
        class="fixed inset-0 pointer-events-none z-0 overflow-hidden"
        aria-hidden="true"
    >
        <!-- Grille SVG : lignes + points lumineux aux intersections -->
        <svg
            class="absolute inset-0 w-full h-full text-primary"
            aria-hidden="true"
        >
            <defs>
                <pattern
                    id="cyber-grid-pattern"
                    width="48"
                    height="48"
                    patternUnits="userSpaceOnUse"
                >
                    <!--
                        Path qui dessine les bordures haut + gauche de chaque
                        cellule. Le pattern se répète automatiquement.
                    -->
                    <path
                        d="M 48 0 L 0 0 0 48"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="0.5"
                    />
                    <!-- Point lumineux à chaque intersection (haut-gauche de cellule) -->
                    <circle cx="0" cy="0" r="1" fill="currentColor" />
                </pattern>
            </defs>
            <rect
                width="100%"
                height="100%"
                fill="url(#cyber-grid-pattern)"
                class="opacity-[0.10] dark:opacity-[0.20]"
            />
        </svg>

        <!-- Halo d'ambiance vert : haut à droite -->
        <div
            class="halo halo-1 absolute -top-20 -right-20 w-96 h-96 rounded-full bg-primary/[0.12] dark:bg-primary/[0.22] blur-[100px]"
            aria-hidden="true"
        ></div>

        <!-- Halo d'ambiance vert : bas à gauche -->
        <div
            class="halo halo-2 absolute -bottom-20 -left-20 w-96 h-96 rounded-full bg-primary/[0.12] dark:bg-primary/[0.22] blur-[100px]"
            aria-hidden="true"
        ></div>
    </div>
</template>

<style scoped>
@keyframes halo-pulse-1 {
    0%, 100% {
        opacity: 0.55;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.04);
    }
}

@keyframes halo-pulse-2 {
    0%, 100% {
        opacity: 0.55;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.06);
    }
}

.halo {
    transform-origin: center;
    will-change: opacity, transform;
}

.halo-1 {
    animation: halo-pulse-1 8s ease-in-out infinite;
}

.halo-2 {
    animation: halo-pulse-2 11s ease-in-out infinite;
}
</style>
