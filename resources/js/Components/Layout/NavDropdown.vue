<script setup>
defineProps({
    label: { type: String, required: true },
    active: { type: Boolean, default: false },
});
</script>

<template>
    <div class="relative group">
        <button
            type="button"
            class="text-sm font-bold px-3 py-1.5 rounded-full transition-colors duration-200 flex items-center gap-1"
            :class="active
                ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10'
                : 'text-ink-light dark:text-white/70 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-black/5 dark:hover:bg-white/5'"
        >
            {{ label }}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6" />
            </svg>
        </button>

        <div
            class="absolute left-0 top-full pt-2 invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 group-focus-within:visible group-focus-within:opacity-100 group-focus-within:translate-y-0 transition-all duration-150"
        >
            <div class="min-w-[160px] rounded-lg border border-slate-200 bg-white shadow-lg py-2 dark:border-slate-700 dark:bg-[#1C222B]">
                <slot />
            </div>
        </div>
    </div>
</template>