<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import CourseContent from '@/components/CourseContent.vue';
import CourseSidebar from '@/components/CourseSidebar.vue';
import CourseSidebarHeader from '@/components/CourseSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <CourseSidebar />
        <CourseContent variant="sidebar">
            <CourseSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </CourseContent>
    </AppShell>
</template>
