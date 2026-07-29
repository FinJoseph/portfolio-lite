<script setup>
import Navbar from '@/Components/Layout/Navbar.vue';
import Footer from '@/Components/Layout/Footer.vue';
import CyberGrid from '@/Components/Layout/CyberGrid.vue';
</script>

<template>
    <div
        class="relative min-h-screen text-ink dark:text-white flex flex-col overflow-hidden bg-paper dark:bg-paper-dark"
    >
        <!-- Fond global : grille cyberpunk + scan line (SVG + CSS, light + dark) -->
        <CyberGrid />

        <Navbar />
        <main class="relative flex-1 pt-28">
            <slot />
        </main>
        <Footer />
    </div>
</template>
