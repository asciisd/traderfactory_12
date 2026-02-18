<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import CourseCard from '@/pages/courses/partials/CourseCard.vue';
import Hero from '@/pages/welcome/Hero.vue';
import Features from '@/pages/welcome/partials/Features.vue';
import { Settings } from '@/types';
import { Courses } from '@/types/courses';
import { Head } from '@inertiajs/vue3';

interface Props {
    settings: Settings;
    courses: Courses;
}

defineProps<Props>();
</script>

<template>
    <GuestLayout>
        <Head title="Welcome" />
        <Hero :settings="settings" />

        <Features class="overflow-hidden py-16 lg:py-12" />

        <div class="mt-8 text-center lg:mt-12">
            <h1 class="text-5xl leading-tight font-extrabold">
                <span class="text-primary">الأستثمار في سوق العملات</span>
            </h1>
        </div>

        <div class="mx-auto w-full max-w-7xl sm:px-6 lg:px-8">
            <CourseCard :courses="courses?.data" />
        </div>
    </GuestLayout>
</template>
