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
        <SkillsPreviewSection :skills="skills" />
        <ProjectsPreviewSection :projects="projects" />
        <TestimonialsPreviewSection :testimonials="testimonials" />
        <ContactCtaSection />
    </AppLayout>
</template>