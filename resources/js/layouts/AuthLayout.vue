<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import { ConfigProvider } from 'reka-ui';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <ConfigProvider :dir="$page.props.locale === 'ar' ? 'rtl' : 'ltr'">
        <AuthLayout :title="title" :description="description">
            <slot />
        </AuthLayout>
    </ConfigProvider>
</template>
