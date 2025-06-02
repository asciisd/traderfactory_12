<script setup lang="ts">
import SectionHead from './SectionHead.vue';
import SectionContent from './SectionContent.vue';
import { Sections } from '@/types/courses';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Separator } from '@/components/ui/separator';
import { Toaster, toast } from 'vue-sonner';
import { watch } from 'vue';

interface Props {
    section: Sections;
    favStatus: boolean | null;
    flash?: {
        success?: string;
        error?: string;
    };
}

const props = defineProps<Props>();

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
    <GuestLayout :title="section.data.meta_title" :section="section.data">
        <Toaster position="top-left" dir="rtl" richColors />
        <div class="max-w-4xl px-4 mx-auto py-12">
            <SectionHead :favStatus="favStatus" :section="section.data" />
            <Separator class="my-8" />
            <SectionContent :canView="section.data.can?.view" :section="section.data" />
        </div>
    </GuestLayout>
</template>
