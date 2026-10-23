<script setup>
import { onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import BaseButton from '@/Components/UI/BaseButton.vue';

const { t } = useI18n();

const mounted = ref(false);

onMounted(() => {
    requestAnimationFrame(() => {
        mounted.value = true;
    });
});
</script>

<template>
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div
            class="relative rounded-3xl overflow-hidden border border-border dark:border-border-dark bg-gradient-to-br from-primary/10 via-primary/5 to-paper dark:from-primary/20 dark:via-primary/10 dark:to-ink px-8 py-16 sm:px-12 sm:py-20 text-center"
        >
            <!-- Background orbs -->
            <span
                aria-hidden="true"
                class="pointer-events-none absolute top-0 left-0 w-64 h-64 rounded-full bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.40),rgba(16,185,129,0.10)_45%,transparent_70%)] animate-float-slow transition-opacity duration-1000 ease-out"
                :class="mounted ? 'opacity-100' : 'opacity-0'"
            ></span>
            <span
                aria-hidden="true"
                class="pointer-events-none absolute bottom-0 right-0 w-48 h-48 rounded-full bg-[radial-gradient(circle_at_center,rgba(52,211,153,0.38),rgba(52,211,153,0.10)_45%,transparent_70%)] animate-float-slow transition-opacity duration-1000 ease-out"
                :class="mounted ? 'opacity-100' : 'opacity-0'"
                style="animation-delay: 1.5s;"
            ></span>
            <span
                aria-hidden="true"
                class="pointer-events-none absolute top-1/2 right-8 -translate-y-1/2 w-32 h-32 rounded-full bg-[radial-gradient(circle_at_center,rgba(16,185,129,0.32),transparent_70%)] transition-opacity duration-1000 ease-out"
                :class="mounted ? 'opacity-100' : 'opacity-0'"
            ></span>

            <!-- Content -->
            <div
                class="relative transition-all duration-700 ease-out"
                :class="mounted
                    ? 'opacity-100 translate-y-0'
                    : 'opacity-0 translate-y-4'"
            >
                <h2 class="text-h2 font-bold text-ink dark:text-white">
                    {{ t('home.contact_cta.title') }}
                </h2>
                <p class="mt-4 text-base sm:text-lg text-ink-light dark:text-white/70 max-w-xl mx-auto">
                    {{ t('home.contact_cta.subtitle') }}
                </p>
                <div class="mt-10">
                    <span class="relative inline-block group/cta">
                        <span
                            aria-hidden="true"
                            class="absolute -inset-1 rounded-full bg-primary/40 dark:bg-primary/30 animate-[ping_2s_ease-in-out_infinite]"
                            :class="mounted ? 'opacity-100' : 'opacity-0'"
                        ></span>
                        <BaseButton
                            :as="Link"
                            href="/contact"
                            variant="primary"
                            class="relative transition-all duration-300 group-hover/cta:scale-[1.05] group-hover/cta:bg-primary-light group-hover/cta:shadow-lg group-hover/cta:shadow-primary/30"
                        >
                            {{ t('home.contact_cta.cta') }}
                        </BaseButton>
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

