<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import type { BreadcrumbItem } from '@/types';
import { Goals } from '@/types/courses';
import { Head, useForm } from '@inertiajs/vue3';
import { onBeforeUnmount } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

interface Props {
    goal: Goals;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.goal.data.section_title,
        href: props.goal.data.section_href,
    },
    {
        title: props.goal.data.title,
        href: props.goal.data.href,
    },
];

onBeforeUnmount(() => {
    if (props.goal.data.user_progress < 100) {
        useForm({ user_progress: 100 }).put(route('goals.progress', props.goal.data.slug), {
            preserveScroll: true,
        });
    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="goal.data.title" />
        <div class="flex h-full flex-1 flex-col items-center justify-center gap-4 p-4">
            <Card class="prose min-w-lg">
                <CardHeader>
                    <CardTitle class="text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl">{{ goal.data.title }} </CardTitle>
                </CardHeader>
                <CardContent class="marker:text-product-pink list-inside">
                    <ul role="list">
                        <li v-for="(point, index) in goal.data.points" :key="index">{{ point }}</li>
                    </ul>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<style scoped></style>
