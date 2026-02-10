<template>
    <QuizLayout :image-url="quizBegin ? '' : quiz.s3_image">
        <div v-if="quizBegin">
            <div v-if="idx < count" class="bg-white rounded-lg shadow-xl">
                <quiz-item :question="questions[idx]" :s3_image="quiz.s3_image" @nextQuestion="nextQuestion"
                           @questionAnswer="answered"/>
            </div>

            <div v-else class="p-12 bg-white rounded-lg shadow-lg w-full mt-8">
                <div>
                    <QuizResult :correct-answers="correctAnswers" :total-answers="count" :wrong-answers="wrongAnswers"
                                @resetQuiz="resetQuiz"/>
                </div>
            </div>
        </div>
        <div v-else>
            <TransitionRoot
                :show="true"
                appear
                as="template"
                enter="transform transition duration-[1500ms]"
                enter-from="opacity-0 rotate-[-120deg] scale-50"
                enter-to="opacity-100 rotate-0 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 rotate-0 scale-100 "
                leave-to="opacity-0 scale-95 ">
                <start-quiz :quiz="quiz" @startQuiz="quizBegin = true"/>
            </TransitionRoot>
        </div>
    </QuizLayout>
</template>

<script>
import {defineComponent} from "vue";
import QuizLayout from "./QuizLayout.vue";
import QuizItem from "./QuizItem.vue";
import {ChevronLeftIcon, ChevronRightIcon} from "@heroicons/vue/24/solid";
import QuizResult from "./QuizResult.vue";
import StartQuiz from "./StartQuiz.vue";
import {TransitionRoot} from '@headlessui/vue'
import {useForm} from '@inertiajs/vue3'

export default defineComponent({
    components: {StartQuiz, QuizResult, QuizItem, QuizLayout, ChevronLeftIcon, ChevronRightIcon, TransitionRoot},
    props: ['quiz'],
    data() {

        return {
            idx: 0,
            selectedAnswer: null,
            correctAnswers: 0,
            wrongAnswers: 0,
            quizBegin: false,
            questions: this.quiz.data.quiz_questions,
            userProgress: 0.0,
        }
    },
    computed: {
        count() {
            return this.questions.length;
        },
        progress() {
            return (this.idx / this.count * 100);
        }
    },
    methods: {
        answered(boolAnswer) {
            this.selectedAnswer = boolAnswer
            if (this.selectedAnswer === this.questions[this.idx].correct_answer) {
                this.correctAnswers++
            } else {
                this.wrongAnswers++
            }
        },
        nextQuestion() {
            this.idx++
            this.selectedAnswer = null
            this.incrementUserProgress();
        },
        incrementUserProgress() {
            if (this.userProgress <= this.progress) {
                this.userProgress = this.progress;
            }
        },
        showResults() {
            this.idx++
        },
        resetQuiz() {
            this.idx = 0
            this.selectedAnswer = null
            this.correctAnswers = 0
            this.wrongAnswers = 0
            this.quizBegin = false
        }
    },
    beforeUnmount() {
        if (this.quiz.user_progress < 100) {
            useForm({
                user_progress: this.userProgress.toFixed(2),
            }).put(route('quizzes.progress', this.quiz), {
                preserveScroll: true,
            })
        }
    }
})
</script>

<style scoped>

</style>
