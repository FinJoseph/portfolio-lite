<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, nextTick, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionHeading from '@/Components/UI/SectionHeading.vue';
import BaseCard from '@/Components/UI/BaseCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import JsonLd from '@/Components/UI/JsonLd.vue';

const { t, locale } = useI18n();

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
    website: '',
});

// Local client-side validation errors (separate from server errors).
const clientErrors = ref({});
const submitting = ref(false);

const flashSuccess = computed(() => usePage().props.flash?.success ?? null);
const settings = computed(() => usePage().props.settings ?? {});
const socialLinks = computed(() => settings.value.social_links ?? {});

const phoneDigits = computed(() =>
    (settings.value.phone || '').replace(/\D/g, ''),
);
const whatsappUrl = computed(() =>
    phoneDigits.value ? `https://wa.me/${phoneDigits.value}` : null,
);

// Current page URL — fallback to window.location when not provided by Inertia.
const currentUrl = computed(() => {
    const propsUrl = usePage().props?.url;
    if (typeof propsUrl === 'string' && propsUrl.length > 0) {
        return propsUrl;
    }
    if (typeof window !== 'undefined' && window.location?.href) {
        return window.location.href;
    }
    return '';
});

const seoTitle = computed(() => t('contact.meta.title', t('contact.page_title')));
const seoDescription = computed(() => t('contact.meta.description', ''));

const jsonLd = computed(() => ({
    '@context': 'https://schema.org',
    '@type': 'ContactPage',
    name: seoTitle.value,
    description: seoDescription.value,
    url: currentUrl.value,
    inLanguage: locale.value,
}));

const emailCopied = ref(false);
let copyResetTimer = null;

async function copyEmail() {
    const email = settings.value.email;
    if (!email) return;

    try {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(email);
        } else {
            window.location.href = `mailto:${email}`;
            return;
        }
        emailCopied.value = true;
        if (copyResetTimer) clearTimeout(copyResetTimer);
        copyResetTimer = setTimeout(() => {
            emailCopied.value = false;
        }, 2000);
    } catch (err) {
        window.location.href = `mailto:${email}`;
    }
}

// Simple but pragmatic email regex (same level of strictness as Laravel's "email" rule).
const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function validate() {
    const errors = {};
    const data = form.data();

    if (!data.name || !String(data.name).trim()) {
        errors.name = t('contact.errors.name_required');
    } else if (String(data.name).length > 100) {
        errors.name = t('contact.errors.name_max');
    }

    if (!data.email || !String(data.email).trim()) {
        errors.email = t('contact.errors.email_required');
    } else if (!EMAIL_REGEX.test(String(data.email).trim())) {
        errors.email = t('contact.errors.email_invalid');
    }

    if (!data.subject || !String(data.subject).trim()) {
        errors.subject = t('contact.errors.subject_required');
    } else if (String(data.subject).length > 150) {
        errors.subject = t('contact.errors.subject_max');
    }

    const message = String(data.message ?? '');
    if (!message.trim()) {
        errors.message = t('contact.errors.message_required');
    } else if (message.length < 10) {
        errors.message = t('contact.errors.message_min');
    } else if (message.length > 5000) {
        errors.message = t('contact.errors.message_max');
    }

    if (data.website && String(data.website).trim() !== '') {
        errors.website = t('contact.errors.honeypot');
    }

    clientErrors.value = errors;
    return Object.keys(errors).length === 0;
}

async function focusFirstError() {
    await nextTick();
    const order = ['name', 'email', 'subject', 'message', 'website'];
    for (const field of order) {
        if (clientErrors.value[field]) {
            const el = document.getElementById(`contact-${field}`);
            if (el && typeof el.focus === 'function') {
                el.focus();
                if (typeof el.scrollIntoView === 'function') {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            return;
        }
    }
}

function submit() {
    if (submitting.value || form.processing) return;

    // Clear stale server errors before client validation runs.
    form.clearErrors();
    clientErrors.value = {};

    if (!validate()) {
        focusFirstError();
        return;
    }

    submitting.value = true;
    form.post('/contact', {
        onSuccess: () => {
            form.reset();
            clientErrors.value = {};
        },
        onFinish: () => {
            submitting.value = false;
        },
    });
}

// Merge client-side and server-side errors for display.
function errorFor(field) {
    return clientErrors.value[field] || form.errors[field] || null;
}
</script>

<template>
    <Head>
        <title>{{ seoTitle }}</title>
        <meta name="description" :content="seoDescription" />
        <link rel="canonical" :href="currentUrl" />

        <!-- Open Graph -->
        <meta property="og:type" content="website" />
        <meta property="og:title" :content="t('contact.meta.og_title', seoTitle)" />
        <meta
            property="og:description"
            :content="t('contact.meta.og_description', seoDescription)"
        />
        <meta property="og:url" :content="currentUrl" />

        <!-- Twitter Cards -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" :content="t('contact.meta.twitter_title', seoTitle)" />
        <meta
            name="twitter:description"
            :content="t('contact.meta.twitter_description', seoDescription)"
        />

    </Head>

    <!-- Schema.org JSON-LD -->
    <JsonLd :json="jsonLd" />

    <AppLayout>
        <section class="max-w-6xl mx-auto px-6 py-16">
            <SectionHeading
                :eyebrow="t('contact.eyebrow')"
                :title="t('contact.heading')"
            />
            <p
                v-if="t('contact.subtitle')"
                class="mt-4 text-ink-light dark:text-white/70 max-w-2xl"
            >
                {{ t('contact.subtitle') }}
            </p>

            <!-- Global success flash (visible when backend confirms submission) -->
            <div
                v-if="flashSuccess"
                role="status"
                aria-live="polite"
                class="mt-8 rounded-xl border border-primary/30 bg-primary/10 dark:bg-primary/15 p-4 text-sm text-primary"
            >
                <p class="font-semibold">
                    {{ t('contact.alerts.success.title', t('contact.success.title')) }}
                </p>
                <p class="mt-1 text-ink-light dark:text-white/70">
                    {{
                        t(
                            'contact.alerts.success.message',
                            t('contact.success.message'),
                        )
                    }}
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Direct contact column -->
                <BaseCard class="p-6 sm:p-8 lg:col-span-2">
                    <div class="space-y-6">
                        <div>
                            <h3
                                class="font-mono text-xs uppercase tracking-widest text-primary"
                            >
                                {{ t('contact.direct.title') }}
                            </h3>
                            <p
                                v-if="t('contact.direct.subtitle')"
                                class="mt-2 text-sm text-ink-light dark:text-white/70"
                            >
                                {{ t('contact.direct.subtitle') }}
                            </p>
                        </div>

                        <div class="space-y-3">
                            <BaseButton
                                v-if="settings.email"
                                :as="'a'"
                                :href="`mailto:${settings.email}`"
                                variant="primary"
                                class="w-full"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                                    />
                                </svg>
                                {{ settings.email }}
                            </BaseButton>

                            <div
                                v-if="settings.email"
                                class="grid grid-cols-1 sm:grid-cols-2 gap-3"
                            >
                                <button
                                    type="button"
                                    @click="copyEmail"
                                    class="inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-sm font-semibold transition-all duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary border border-border dark:border-border-dark text-ink dark:text-white hover:border-primary hover:text-primary dark:hover:text-primary"
                                >
                                    <svg
                                        v-if="!emailCopied"
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"
                                        />
                                    </svg>
                                    <svg
                                        v-else
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5"
                                        />
                                    </svg>
                                    <span>{{
                                        emailCopied
                                            ? t('contact.direct.copied')
                                            : t('contact.direct.copy_email')
                                    }}</span>
                                </button>

                                <BaseButton
                                    v-if="whatsappUrl"
                                    :as="'a'"
                                    :href="whatsappUrl"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    variant="secondary"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.683 5.473l-.999 3.648 3.805-.82zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"
                                        />
                                    </svg>
                                    {{ t('contact.direct.whatsapp') }}
                                </BaseButton>
                            </div>

                            <BaseButton
                                v-if="settings.phone"
                                :as="'a'"
                                :href="`tel:${settings.phone}`"
                                variant="secondary"
                                class="w-full"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"
                                    />
                                </svg>
                                {{ t('contact.direct.phone') }}
                                <span
                                    v-if="settings.phone"
                                    class="ml-auto text-xs font-mono text-muted"
                                >{{ settings.phone }}</span>
                            </BaseButton>
                        </div>

                        <div
                            v-if="
                                socialLinks.github ||
                                socialLinks.linkedin ||
                                socialLinks.twitter
                            "
                            class="pt-5 border-t border-border dark:border-border-dark"
                        >
                            <p
                                class="text-xs font-mono uppercase tracking-widest text-muted mb-3"
                            >
                                {{ t('contact.direct.socials') }}
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <BaseButton
                                    v-if="socialLinks.github"
                                    :as="'a'"
                                    :href="socialLinks.github"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    variant="ghost"
                                >
                                    GitHub
                                </BaseButton>
                                <BaseButton
                                    v-if="socialLinks.linkedin"
                                    :as="'a'"
                                    :href="socialLinks.linkedin"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    variant="ghost"
                                >
                                    LinkedIn
                                </BaseButton>
                                <BaseButton
                                    v-if="socialLinks.twitter"
                                    :as="'a'"
                                    :href="socialLinks.twitter"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    variant="ghost"
                                >
                                    Twitter / X
                                </BaseButton>
                            </div>
                        </div>
                    </div>
                </BaseCard>

                <!-- Form column -->
                <BaseCard class="p-6 sm:p-8 lg:col-span-3">
                    <form
                        @submit.prevent="submit"
                        novalidate
                        class="space-y-5"
                        aria-labelledby="contact-form-title"
                    >
                        <div>
                            <h3
                                id="contact-form-title"
                                class="text-lg font-semibold text-ink dark:text-white"
                            >
                                {{ t('contact.form.title') }}
                            </h3>
                            <p
                                v-if="t('contact.form.subtitle')"
                                class="mt-1 text-sm text-ink-light dark:text-white/70"
                            >
                                {{ t('contact.form.subtitle') }}
                            </p>
                        </div>

                        <!-- Honeypot: hidden from sighted users and keyboard users -->
                        <div
                            style="position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;"
                            aria-hidden="true"
                        >
                            <label for="contact-website">Website</label>
                            <input
                                id="contact-website"
                                v-model="form.website"
                                type="text"
                                name="website"
                                tabindex="-1"
                                autocomplete="off"
                                aria-hidden="true"
                            />
                        </div>

                        <!-- Name -->
                        <div>
                            <label
                                for="contact-name"
                                class="block text-sm font-medium text-ink dark:text-white"
                            >
                                {{ t('contact.fields.name') }}
                            </label>
                            <input
                                id="contact-name"
                                v-model="form.name"
                                type="text"
                                name="name"
                                autocomplete="name"
                                maxlength="100"
                                :aria-invalid="errorFor('name') ? 'true' : 'false'"
                                :aria-describedby="
                                    errorFor('name') ? 'contact-name-error' : null
                                "
                                :placeholder="t('contact.placeholders.name')"
                                class="mt-1.5 block w-full rounded-lg border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 px-3 py-2 text-sm text-ink dark:text-white placeholder:text-muted focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                :class="{
                                    'border-red-500 focus:border-red-500 focus:ring-red-500': errorFor('name'),
                                }"
                            />
                            <p
                                v-if="errorFor('name')"
                                id="contact-name-error"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errorFor('name') }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                for="contact-email"
                                class="block text-sm font-medium text-ink dark:text-white"
                            >
                                {{ t('contact.fields.email') }}
                            </label>
                            <input
                                id="contact-email"
                                v-model="form.email"
                                type="email"
                                name="email"
                                autocomplete="email"
                                :aria-invalid="errorFor('email') ? 'true' : 'false'"
                                :aria-describedby="
                                    errorFor('email') ? 'contact-email-error' : null
                                "
                                :placeholder="t('contact.placeholders.email')"
                                class="mt-1.5 block w-full rounded-lg border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 px-3 py-2 text-sm text-ink dark:text-white placeholder:text-muted focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                :class="{
                                    'border-red-500 focus:border-red-500 focus:ring-red-500': errorFor('email'),
                                }"
                            />
                            <p
                                v-if="errorFor('email')"
                                id="contact-email-error"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errorFor('email') }}
                            </p>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label
                                for="contact-subject"
                                class="block text-sm font-medium text-ink dark:text-white"
                            >
                                {{ t('contact.fields.subject') }}
                            </label>
                            <input
                                id="contact-subject"
                                v-model="form.subject"
                                type="text"
                                name="subject"
                                maxlength="150"
                                :aria-invalid="errorFor('subject') ? 'true' : 'false'"
                                :aria-describedby="
                                    errorFor('subject') ? 'contact-subject-error' : null
                                "
                                :placeholder="t('contact.placeholders.subject')"
                                class="mt-1.5 block w-full rounded-lg border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 px-3 py-2 text-sm text-ink dark:text-white placeholder:text-muted focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                :class="{
                                    'border-red-500 focus:border-red-500 focus:ring-red-500': errorFor('subject'),
                                }"
                            />
                            <p
                                v-if="errorFor('subject')"
                                id="contact-subject-error"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errorFor('subject') }}
                            </p>
                        </div>

                        <!-- Message -->
                        <div>
                            <label
                                for="contact-message"
                                class="block text-sm font-medium text-ink dark:text-white"
                            >
                                {{ t('contact.fields.message') }}
                            </label>
                            <textarea
                                id="contact-message"
                                v-model="form.message"
                                name="message"
                                rows="6"
                                maxlength="5000"
                                :aria-invalid="errorFor('message') ? 'true' : 'false'"
                                :aria-describedby="
                                    errorFor('message') ? 'contact-message-error' : null
                                "
                                :placeholder="t('contact.placeholders.message')"
                                class="mt-1.5 block w-full rounded-lg border border-border dark:border-border-dark bg-white dark:bg-ink-light/30 px-3 py-2 text-sm text-ink dark:text-white placeholder:text-muted focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary resize-y"
                                :class="{
                                    'border-red-500 focus:border-red-500 focus:ring-red-500': errorFor('message'),
                                }"
                            />
                            <p
                                v-if="errorFor('message')"
                                id="contact-message-error"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ errorFor('message') }}
                            </p>
                        </div>

                        <div class="pt-2">
                            <BaseButton
                                type="submit"
                                variant="primary"
                                :disabled="form.processing || submitting"
                            >
                                <svg
                                    v-if="form.processing || submitting"
                                    class="w-4 h-4 animate-spin"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    />
                                </svg>
                                <span>{{
                                    form.processing || submitting
                                        ? t('contact.status.sending')
                                        : t('contact.status.send')
                                }}</span>
                            </BaseButton>
                        </div>
                    </form>
                </BaseCard>
            </div>
        </section>
    </AppLayout>
</template>