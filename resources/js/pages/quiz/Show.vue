<template>
    <quiz-list :quiz="quiz"/>
</template>

<script>
import {defineComponent} from "vue";
import QuizList from "./QuizList.vue";
import LessonLayout from "@/layouts/LessonLayout.vue";

export default defineComponent({
    layout: LessonLayout,
    props: {
        quiz: {
            type: Object,
            default: {},
            required: true
        }
    },
    components: {QuizList}
})
</script>
