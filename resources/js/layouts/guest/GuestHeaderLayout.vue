<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import GuestContent from '@/components/GuestContent.vue';
import GuestHeader from '@/components/GuestHeader.vue';
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
    <ConfigProvider dir="rtl">
        <AppShell class="flex-col">
            <GuestHeader :breadcrumbs="breadcrumbs" />
            <GuestContent>
                <slot />
            </GuestContent>
        </AppShell>
    </ConfigProvider>
</template>
