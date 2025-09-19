<script setup lang="ts">
import SectionHead from './SectionHead.vue';
import SectionContent from './SectionContent.vue';
import { Sections } from '@/types/courses';
import { Separator } from '@/components/ui/separator';
import { Toaster, toast } from 'vue-sonner';
import { watch } from 'vue';
import CourseLayout from '@/layouts/CourseLayout.vue';
import { Head } from '@inertiajs/vue3';
import type { BreadcrumbItem, Flash } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

interface Props {
    section: Sections;
    favStatus: boolean | null;
    flash?: Flash;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.section.data.title,
        href: '#',
    }
];

watch(
    () => props.flash?.success,
    (successMessage) => {
        if (successMessage) {
            toast.success(successMessage);
        }
    },
);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="section.data.meta_title" />
        <Toaster position="top-left" dir="rtl" richColors />
        <div class="max-w-3xl px-4 mx-auto py-12">
            <SectionHead :favStatus="favStatus" :section="section.data" />
            <Separator class="my-8" />
            <SectionContent :canView="section.data.can?.view" :section="section.data" />
        </div>
    </AppLayout>
</template>
