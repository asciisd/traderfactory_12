<script setup lang="ts">
import GuestLayout from '@/layouts/guest/GuestHeaderLayout.vue';
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
        <GuestLayout :breadcrumbs="breadcrumbs">
            <slot />
        </GuestLayout>
    </ConfigProvider>
</template>
