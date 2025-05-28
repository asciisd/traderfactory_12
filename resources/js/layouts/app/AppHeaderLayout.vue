<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
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
        <AppShell class="flex-col">
            <AppHeader :breadcrumbs="breadcrumbs" />
            <AppContent>
                <slot />
            </AppContent>
        </AppShell>
    </ConfigProvider>
</template>
