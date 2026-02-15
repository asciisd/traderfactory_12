<template>
    <Head :title="title"/>

    <!--    <survey/>-->

    <Main class="bg-secondary sticky inset-0 top-0"/>

    <div class="min-h-screen">
        <slot name="header">

        </slot>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>
    </div>

    <FooterSocialLinksOnly/>
</template>

<script>
import FooterSocialLinksOnly from "@/components/footers/FooterSocialLinksOnly.vue";
import {Head} from '@inertiajs/vue3';
import Main from "@/components/menu/Main.vue";
import Survey from '@/pages/Survey.vue'

export default {
    components: {FooterSocialLinksOnly, Survey, Main, Head},
    props: ['title']
}
</script>

<style scoped>

</style>
