<script setup lang="ts">
import Banner from '@/components/Banner.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType, Metadata } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    metadata?: Metadata;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head v-if="metadata" :title="metadata?.title">
            <meta v-if="metadata?.keywords" :content="metadata?.keywords" name="keywords" />

            <meta v-if="metadata?.description" :content="metadata?.description" name="description" />
            <meta v-if="metadata?.description" :content="metadata?.description" name="twitter:description" />
            <meta v-if="metadata?.description" :content="metadata?.description" property="og:description" />

            <meta v-if="metadata?.image" :content="metadata?.image" name="image" />
            <meta v-if="metadata?.image" :content="metadata?.image" name="twitter:image" />
            <meta v-if="metadata?.image" :content="metadata?.image" property="og:image" />
        </Head>

        <Banner />

        <div class="min-h-screen">
            <!-- Page Heading -->
            <header v-if="$slots.header" class="shadow">
                <div>
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </AppLayout>
</template>
