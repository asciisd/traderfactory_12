<script setup lang="ts">
import FooterSocialLinksOnly from '@/components/footers/FooterSocialLinksOnly.vue';
import { Head } from '@inertiajs/vue3';
import GuestHeaderLayout from './guest/GuestHeaderLayout.vue';
</script>

<template>
    <Head :title="title" />

    <GuestHeaderLayout class="min-h-screen">
        <slot name="header"> </slot>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>
    </GuestHeaderLayout>

    <FooterSocialLinksOnly />
</template>
