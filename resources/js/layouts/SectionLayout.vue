<script setup>
import ExitMenu from "@/Components/Menu/ExitMenu.vue";
import SideOver from "@/Pages/Section/Partials/SideOver.vue";
import {Head} from '@inertiajs/vue3'

defineProps({
    title: String,
    section: {
        type: Object,
        default: {},
        required: true
    }
})
</script>

<template>
    <Head :title="title">
        <meta :content="section.meta_title ?? title" name="title">
        <meta :content="section.meta_description" name="description">
        <meta :content="section.meta_image" name="image">
        <meta :content="section.meta_keywords" name="keywords">

        <meta :content="section.meta_title" property="og:title">
        <meta :content="section.meta_description" property="og:description">
        <meta :content="section.meta_image" property="og:image">

        <meta :content="section.meta_title" name="twitter:title">
        <meta :content="section.meta_description" name="twitter:description">
        <meta :content="section.meta_image" name="twitter:image">
    </Head>

    <div>
        <ExitMenu v-if="$page.component !== 'Section/Index'" :slug="section.slug"/>
        <SideOver :slug="section.slug"/>
        <slot></slot>
    </div>
</template>
