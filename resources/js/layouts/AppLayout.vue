<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
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
        <AppLayout :breadcrumbs="breadcrumbs">
            <slot />
        </AppLayout>
    </ConfigProvider>
</template>
