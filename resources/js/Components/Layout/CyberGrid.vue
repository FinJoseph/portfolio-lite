<script setup>
/*
 * CyberGrid — fond « cyberpunk / tech avancé » 100% SVG + CSS, zéro JS.
 *
 * Composition :
 *  1. Une grille SVG plein écran (cellules 48×48) avec petits points lumineux
 *     aux intersections — donne le côté « circuit board / terminal ».
 *  2. Deux halos verts d'ambiance, positionnés en diagonale, dessinés en
 *     dégradé radial (et non en blur CSS) et animés par une pulsation
 *     d'opacité désynchronisée : vivant, mais sans coût GPU continu.
 *
 * Light / Dark :
 *  - Pas de @media (prefers-color-scheme) ni de JS pour détecter le mode :
 *    on s'appuie sur la classe .dark que useDarkMode pose déjà sur <html>.
 *    Tailwind traduit ça automatiquement avec les variants dark:.
 *  - Opacité plus marquée en sombre qu'en clair.
 *
 * Perf :
 *  - Aucun canvas, aucune animation JS, aucun listener d'événement.
 *  - Aucun `filter: blur()` : les halos sont des dégradés radiaux.
 *  - Seule l'opacity est animée (composité GPU), pas de will-change permanent.
 *  - Le mouvement est neutralisé si l'utilisateur demande prefers-reduced-motion.
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

        <!-- Halo d'ambiance vert : haut à droite
             Dégradé radial au lieu d'un filter: blur(100px) :
             même rendu visuel, mais aucune couche GPU floutée à recomposer. -->
        <div
            class="halo absolute -top-24 -right-24 h-[26rem] w-[26rem] rounded-full bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.20),rgba(16,185,129,0.07)_45%,transparent_70%)] dark:bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.30),rgba(16,185,129,0.10)_45%,transparent_70%)] animate-halo"
            aria-hidden="true"
        ></div>

        <!-- Halo d'ambiance vert : bas à gauche (décalé pour désynchroniser la pulsation) -->
        <div
            class="halo absolute -bottom-24 -left-24 h-[26rem] w-[26rem] rounded-full bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.20),rgba(16,185,129,0.07)_45%,transparent_70%)] dark:bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.30),rgba(16,185,129,0.10)_45%,transparent_70%)] animate-halo"
            style="animation-delay: -7s"
            aria-hidden="true"
        ></div>
    </div>
</template>

<style scoped>
/*
 * Les halos n'utilisent plus `filter: blur()` ni `will-change` permanent :
 * le dégradé radial est rasterisé une seule fois, l'animation ne joue que sur
 * l'opacity (composité GPU, sans repaint). Aucun `will-change` statique → pas de
 * couche mémoire retenue en permanence.
 */
.halo {
    transform: translateZ(0);
}
</style>
