<script>
import RadialProgress from "vue3-radial-progress";

export default {
    emits: ['resetQuiz'],
    props: {
        correctAnswers: {
            type: Number,
            default: 0
        },
        wrongAnswers: {
            type: Number,
            default: 0
        },
        totalAnswers: {
            type: Number,
            default: 0
        }
    },
    components: {
        RadialProgress
    },
    computed: {
        correctAnswersPercentage() {
            return Math.round(this.correctAnswers / this.totalAnswers * 100).toExponential(0)
        },
        wrongAnswersPercentage() {
            return Math.round(this.wrongAnswers / this.totalAnswers * 100).toExponential(0)
        },
        score() {
            return this.calculateScore();
        },
        pass() {
            return this.calculateScore() >= 65
        },
        progressColor() {
            return this.calculateScore() >= 65 ? '#A1C814' : '#EF4444'
        }
    },
    methods: {
        resetQuiz() {
            this.$emit('resetQuiz');
        },
        exitQuiz() {
            window.history.back();
        },
        calculateScore() {
            return Math.round((this.correctAnswers / this.totalAnswers) * 100).toFixed(0)
        }
    }
}
</script>

<template>
    <div class="flex flex-col gap-6">
        <h2 class="text-3xl font-semibold leading-loose text-secondary">النتيجة</h2>
        <div class="flex gap-3 items-center">
            <RadialProgress :completed-steps="correctAnswersPercentage" :diameter="70" :inner-stroke-width="4"
                            :stroke-width="4" :total-steps="100" inner-stroke-color="rgb(209 213 219)"
                            start-color="#017ea1" stop-color="#017ea1">
                <p class="m-2">{{ score }}%</p>
            </RadialProgress>
            <p class="leading-loose text-lg text-primary">الاجابات الصحيحة:
                <span class="leading-loose text-lg text-primary">{{ correctAnswers }}</span>
            </p>
        </div>

        <div class="flex gap-3 items-center">
            <RadialProgress :completed-steps="wrongAnswersPercentage" :diameter="70" :inner-stroke-width="4"
                            :stroke-width="4" :total-steps="100" inner-stroke-color="rgb(209 213 219)"
                            start-color="#82055f" stop-color="#82055f">
                <p class="m-2">{{ wrongAnswers }}%</p>
            </RadialProgress>
            <p class="leading-loose text-lg text-pink">الاجابات الخاطئة: <span class="leading-loose text-lg text-pink">{{
                    wrongAnswers
                }}</span></p>
        </div>

        <div class="mt-6 flow-root">
            <button v-if="correctAnswers < 2"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                    type="button" @click="resetQuiz">
                حاول مرة اخرى
            </button>

            <button v-else
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                    type="button" @click="exitQuiz">
                انهاء الاختبار
            </button>
        </div>
    </div>
</template>
