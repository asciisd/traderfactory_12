<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import CourseCard from '@/pages/courses/partials/CourseCard.vue';

interface Props {
    courses: any;
}
defineProps<Props>();
</script>

<template>
    <AppLayout title="Courses">
        <div class="mt-8 text-center lg:mt-12">
            <h1 class="text-5xl leading-tight font-extrabold">
                <span class="text-pink">الأستثمار في سوق العملات</span>
            </h1>
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <CourseCard :courses="courses.data" />
        </div>
    </AppLayout>
</template>
