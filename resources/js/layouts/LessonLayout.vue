<template>
    <Head>
        <meta v-if="lesson.meta_description" :content="lesson.meta_description" name="description">
        <meta v-if="lesson.meta_keywords" :content="lesson.meta_keywords" name="keywords">
        <title v-if="lesson.meta_title">{{ lesson.meta_title }}</title>
    </Head>

    <div>
        <ExitMenu v-if="$page.component !== 'Section/Index'" :slug="lesson.section_slug"/>
        <slot></slot>
    </div>
</template>

<script>
import ExitMenu from "@/components/menu/ExitMenu.vue";
import {Head} from "@inertiajs/vue3";

export default {
    props: {
        lesson: {
            type: Object,
            default: {},
            required: true
        }
    },
    components: {
        ExitMenu,
        Head
    }
}
</script>
