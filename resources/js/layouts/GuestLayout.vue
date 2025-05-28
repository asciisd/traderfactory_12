<script setup lang="ts">
import GuestLayout from '@/layouts/guest/GuestHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <GuestLayout :breadcrumbs="breadcrumbs">
        <slot />
    </GuestLayout>
</template>
