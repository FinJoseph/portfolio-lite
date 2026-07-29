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
                class="pointer-events-none absolute top-0 left-0 w-64 h-64 rounded-full bg-primary/30 dark:bg-primary/20 blur-[80px] animate-[float_6s_ease-in-out_infinite] transition-opacity duration-1000 ease-out"
                :class="mounted ? 'opacity-100' : 'opacity-0'"
            ></span>
            <span
                aria-hidden="true"
                class="pointer-events-none absolute bottom-0 right-0 w-48 h-48 rounded-full bg-primary-light/30 dark:bg-primary-light/20 blur-[60px] animate-[float-delayed_8s_ease-in-out_infinite] transition-opacity duration-1000 ease-out"
                :class="mounted ? 'opacity-100' : 'opacity-0'"
                style="animation-delay: 1.5s;"
            ></span>
            <span
                aria-hidden="true"
                class="pointer-events-none absolute top-1/2 right-8 -translate-y-1/2 w-32 h-32 rounded-full bg-primary/25 dark:bg-primary/15 blur-[50px] animate-[pulse-soft_4s_ease-in-out_infinite] transition-opacity duration-1000 ease-out"
                :class="mounted ? 'opacity-100' : 'opacity-0'"
                style="animation-delay: 0.5s;"
            ></span>

            <!-- Content -->
            <div
                class="relative transition-all duration-700 ease-out"
                :class="mounted
                    ? 'opacity-100 translate-y-0'
                    : 'opacity-0 translate-y-4'"
            >
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-ink dark:text-white">
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

<style scoped>
@keyframes float {
    0%,
    100% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(0, -18px);
    }
}

@keyframes float-delayed {
    0%,
    100% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(0, -14px);
    }
}

@keyframes pulse-soft {
    0%,
    100% {
        transform: translateY(-50%) scale(1);
        opacity: 0.75;
    }
    50% {
        transform: translateY(-50%) scale(1.12);
        opacity: 1;
    }
}
</style>
