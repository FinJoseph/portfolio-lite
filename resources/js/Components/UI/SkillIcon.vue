<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: { type: String, required: true },
    size: { type: String, default: 'w-8 h-8' },
});

const normalized = computed(() => String(props.name || '').trim().toLowerCase().replace(/[\s_-]+/g, ''));

function is(...candidates) {
    return candidates.includes(normalized.value);
}
</script>

<template>
    <!-- Laravel -->
    <svg
        v-if="is('laravel')"
        :class="size"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path
            d="M5.5 17.5L2 15.5L12 9.5L22 15.5L18.5 17.5L12 13.5L5.5 17.5Z"
            fill="currentColor"
        />
        <path
            d="M5.5 21L2 19L12 13L22 19L18.5 21L12 17L5.5 21Z"
            fill="currentColor"
            opacity="0.5"
        />
        <path
            d="M2 8.5L12 2.5L22 8.5L12 14.5L2 8.5ZM12 4.5L5.5 8.5L12 12.5L18.5 8.5L12 4.5Z"
            fill="currentColor"
            opacity="0.85"
        />
    </svg>

    <!-- Vue.js -->
    <svg
        v-else-if="is('vuejs', 'vue')"
        :class="size"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path
            d="M12 3L19.5 18.5H17L12 9.25L7 18.5H4.5L12 3Z"
            fill="currentColor"
        />
        <path
            d="M7.5 18.5L12 10.25L16.5 18.5H14L12 15L10 18.5H7.5Z"
            fill="currentColor"
            opacity="0.6"
        />
    </svg>

    <!-- Tailwind CSS -->
    <svg
        v-else-if="is('tailwindcss', 'tailwind')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.8-1.6 3.6-2.4 5.4-2.4 1.2 0 2.4.4 3.6 1.2 1.2.8 2.4 1.2 3.6 1.2 3.2 0 5.2-1.6 6-4.8-1.8 1.6-3.6 2.4-5.4 2.4-1.2 0-2.4-.4-3.6-1.2-1.2-.8-2.4-1.2-3.6-1.2zM6.001 12c-3.2 0-5.2 1.6-6 4.8 1.8-1.6 3.6-2.4 5.4-2.4 1.2 0 2.4.4 3.6 1.2 1.2.8 2.4 1.2 3.6 1.2 3.2 0 5.2-1.6 6-4.8-1.8 1.6-3.6 2.4-5.4 2.4-1.2 0-2.4-.4-3.6-1.2-1.2-.8-2.4-1.2-3.6-1.2z" />
    </svg>

    <!-- PHP -->
    <svg
        v-else-if="is('php')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path d="M3 3h18a2 2 0 012 2v10a2 2 0 01-2 2h-7l-3 4v-4H3a2 2 0 01-2-2V5a2 2 0 012-2z" opacity="0.85"/>
        <text x="6.5" y="13" font-family="monospace" font-weight="bold" font-size="7" fill="white">php</text>
    </svg>

    <!-- MySQL -->
    <svg
        v-else-if="is('mysql')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path d="M12 2c-1.5 0-3 .5-4 1.5-1 1-1.5 2.5-1.5 4 0 1 .3 2 .8 2.8L4.5 13c-.5 1-.5 2 0 3 .5 1 1.5 1.5 2.5 1.5.5 0 1-.1 1.5-.3.3 1 1 1.8 2 2.3 1 .5 2 .7 3 .7s2-.2 3-.7c1-.5 1.7-1.3 2-2.3.5.2 1 .3 1.5.3 1 0 2-.5 2.5-1.5.5-1 .5-2 0-3l-2.8-2.7c.5-.8.8-1.8.8-2.8 0-1.5-.5-3-1.5-4-1-1-2.5-1.5-4-1.5z" opacity="0.85"/>
        <ellipse cx="9" cy="11" rx="1.2" ry="1.5" fill="white" opacity="0.7"/>
        <ellipse cx="15" cy="11" rx="1.2" ry="1.5" fill="white" opacity="0.7"/>
    </svg>

    <!-- Inertia -->
    <svg
        v-else-if="is('inertia', 'inertiajs')"
        :class="size"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path d="M3 12a9 9 0 1118 0 9 9 0 01-18 0z" stroke="currentColor" stroke-width="2"/>
        <path d="M8 12l4-4 4 4-4 4-4-4z" fill="currentColor"/>
    </svg>

    <!-- JavaScript -->
    <svg
        v-else-if="is('javascript', 'js')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <rect width="24" height="24" rx="3" fill="currentColor"/>
        <text x="3" y="17" font-family="monospace" font-weight="bold" font-size="11" fill="white">JS</text>
    </svg>

    <!-- TypeScript -->
    <svg
        v-else-if="is('typescript', 'ts')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <rect width="24" height="24" rx="3" fill="currentColor"/>
        <text x="3" y="17" font-family="monospace" font-weight="bold" font-size="11" fill="white">TS</text>
    </svg>

    <!-- React -->
    <svg
        v-else-if="is('react', 'reactjs')"
        :class="size"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <circle cx="12" cy="12" r="2" fill="currentColor"/>
        <ellipse cx="12" cy="12" rx="10" ry="4" stroke="currentColor" stroke-width="1.5"/>
        <ellipse cx="12" cy="12" rx="10" ry="4" stroke="currentColor" stroke-width="1.5" transform="rotate(60 12 12)"/>
        <ellipse cx="12" cy="12" rx="10" ry="4" stroke="currentColor" stroke-width="1.5" transform="rotate(120 12 12)"/>
    </svg>

    <!-- Git -->
    <svg
        v-else-if="is('git')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path d="M12 2L4 6v6c0 5 3.5 9.5 8 10 4.5-.5 8-5 8-10V6l-8-4zm-1 14a3 3 0 11-2-2.8V8a2 2 0 112 0v5.2c.6.4 1 1 1 1.8 0 .6-.4 1-1 1z" opacity="0.85"/>
        <circle cx="17" cy="6" r="1.5" fill="white" opacity="0.7"/>
    </svg>

    <!-- Docker -->
    <svg
        v-else-if="is('docker')"
        :class="size"
        viewBox="0 0 24 24"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <path d="M3 9h2v3H3V9zm3-2h2v3H6V7zm3-2h2v3H9V5zm3 0h2v3h-2V5zm3 2h2v3h-2V7zm-9 4h2v3H6v-3zm3 0h2v3H9v-3zm3 0h2v3h-2v-3zm-6 0h2v3H6v-3z" opacity="0.85"/>
        <path d="M2 13c.5 4 4 6 8 6 5 0 9-3 10-7-1 0-2-.5-2-1.5 0-.8.5-1.5 1-2-.5-.5-1.5-.5-2 0-.5-.5-1.5-.5-2 0-.5-.5-1.5-.5-2 0 0-1-1-1.5-2-1.5v6H2z"/>
    </svg>

    <!-- Figma -->
    <svg
        v-else-if="is('figma')"
        :class="size"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <circle cx="9" cy="6" r="3" fill="currentColor"/>
        <circle cx="15" cy="6" r="3" fill="currentColor" opacity="0.7"/>
        <circle cx="9" cy="12" r="3" fill="currentColor" opacity="0.85"/>
        <circle cx="15" cy="12" r="3" fill="currentColor" opacity="0.55"/>
        <path d="M9 15a3 3 0 013 3v3a3 3 0 11-3-3 3 3 0 010-3z" fill="currentColor" opacity="0.4"/>
    </svg>

    <!-- Fallback: generic code/terminal icon -->
    <svg
        v-else
        :class="size"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <polyline points="16 18 22 12 16 6" />
        <polyline points="8 6 2 12 8 18" />
    </svg>
</template>
