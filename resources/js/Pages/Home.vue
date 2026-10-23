<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroSection from '@/Components/Home/HeroSection.vue';
import SkillsPreviewSection from '@/Components/Home/SkillsPreviewSection.vue';
import ProjectsPreviewSection from '@/Components/Home/ProjectsPreviewSection.vue';
import TestimonialsPreviewSection from '@/Components/Home/TestimonialsPreviewSection.vue';
import ContactCtaSection from '@/Components/Home/ContactCtaSection.vue';

defineProps({
    skills: { type: Array, default: () => [] },
    projects: { type: Array, default: () => [] },
    testimonials: { type: Array, default: () => [] },
});
</script>

<template>
    <AppLayout>
        <HeroSection />
        <SkillsPreviewSection v-reveal :skills="skills" />
        <ProjectsPreviewSection v-reveal :projects="projects" />
        <TestimonialsPreviewSection v-reveal :testimonials="testimonials" />
        <ContactCtaSection v-reveal />
    </AppLayout>
</template>