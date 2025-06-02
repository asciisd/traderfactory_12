<script setup lang="ts">
import AppShell from '@/components/AppShell.vue';
import GuestContent from '@/components/GuestContent.vue';
import GuestHeader from '@/components/GuestHeader.vue';
import GuestFooter from '@/components/GuestFooter.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell class="flex-col">
        <GuestHeader :breadcrumbs="breadcrumbs" />
        <GuestContent>
            <slot />
        </GuestContent>
    </AppShell>
    <GuestFooter />
</template>
