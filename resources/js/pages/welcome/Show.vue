<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

interface Props {
    course: object;
}

defineProps<Props>();
</script>

<template>
    <Head :title="course.metadata.title">
        <meta :content="course.metadata.description" name="description" />
        <meta :content="course.metadata.keywords" name="keywords" />
    </Head>

    <h1>This single course details</h1>
</template>
