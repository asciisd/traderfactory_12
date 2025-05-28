<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { type Courses } from '@/types/courses';
import { Head } from '@inertiajs/vue3';
import CourseCard from './partials/CourseCard.vue';

interface Props {
    courses: Courses;
}

defineProps<Props>();
</script>

<template>
    <GuestLayout>
        <Head title="Courses" />
        <div class="mt-8 text-center lg:mt-12">
            <h1 class="text-5xl leading-tight font-extrabold">
                <span class="text-pink">الأستثمار في سوق العملات</span>
            </h1>
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <CourseCard :courses="courses.data" />
        </div>
    </GuestLayout>
</template>
