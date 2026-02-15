<template>
    <QuickScanList :quick-scan="quickScan"/>
</template>

<script>
import {defineComponent} from "vue";
import QuickScanList from "./partials/QuickScanList.vue";
import SkillsLayout from "@/layouts/LessonLayout.vue";

export default defineComponent({
    layout: SkillsLayout,
    props: {
        quickScan: {
            type: Object,
            default: {},
            required: true
        }
    },
    components: {QuickScanList}
})
</script>
