<script setup lang="ts">
import SectionHead from "./SectionHead.vue";
import SectionContent from "./SectionContent.vue";
import AppLayout from "@/layouts/AppLayout.vue";

defineProps({
    section: Object,
    favStatus: Boolean
})
</script>

<template>
    <AppLayout :title="section.meta_title" :section="section">
        <SectionHead :fav-status="favStatus" :section="section"/>

        <SectionContent :canView="section.can.view" :section="section"/>
    </AppLayout>
</template>
