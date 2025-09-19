<script setup lang="ts">
import CourseLayout from '@/layouts/course/CourseSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { ConfigProvider } from 'reka-ui';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <ConfigProvider :dir="$page.props.locale === 'ar' ? 'rtl' : 'ltr'">
        <CourseLayout :breadcrumbs="breadcrumbs">
            <slot />
        </CourseLayout>
    </ConfigProvider>
</template>
