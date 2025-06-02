<script setup lang="ts">
import { Course } from '@/types/courses';
import { Head } from '@inertiajs/vue3';

interface Props {
    course: Course;
}

defineProps<Props>();
</script>
<template>
    <Head :title="course.meta_title">
        <meta :content="course.meta_description" name="description" />
        <meta :content="course.meta_keywords" name="keywords" />
    </Head>

    <h1>This single course details</h1>
</template>
