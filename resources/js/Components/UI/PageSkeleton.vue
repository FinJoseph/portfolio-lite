<script setup>
/*
 * PageSkeleton — squelette affiché pendant le chargement du chunk JS d'une page.
 * Évite le flash blanc et donne l'impression d'une navigation instantanée.
 * Utilise uniquement des dégradés (pas de filter: blur) : coût de rendu minimal.
 */
</script>

<template>
    <div class="w-full px-6 py-16" role="status" aria-live="polite" aria-label="Chargement">
        <span class="sr-only">Chargement de la page…</span>

        <div class="mx-auto w-full max-w-7xl space-y-10">
            <!-- Sur-titre + titre -->
            <div class="space-y-4">
                <div class="skeleton h-3 w-28 rounded-full"></div>
                <div class="skeleton h-11 w-2/3 max-w-xl rounded-2xl"></div>
                <div class="skeleton h-4 w-1/2 max-w-md rounded-full"></div>
            </div>

            <!-- Grille de contenu -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="index in 6"
                    :key="index"
                    class="skeleton h-64 rounded-card"
                ></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.skeleton {
    background-image: linear-gradient(
        100deg,
        var(--surface-2) 20%,
        var(--surface-3) 40%,
        var(--surface-2) 60%
    );
    background-size: 200% 100%;
    animation: skeleton-shimmer 1.4s ease-in-out infinite;
}

@keyframes skeleton-shimmer {
    from {
        background-position: 160% 0;
    }
    to {
        background-position: -40% 0;
    }
}
</style>
