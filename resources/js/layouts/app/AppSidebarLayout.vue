<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
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
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar">
                <AppSidebarHeader :breadcrumbs="breadcrumbs" />
                <slot />
            </AppContent>
        </AppShell>
    </ConfigProvider>
</template>
