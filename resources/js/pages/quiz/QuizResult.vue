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
            if (this.correctAnswers / this.totalAnswers * 100 === 0)
                return 0;
            return Math.round(this.correctAnswers / this.totalAnswers * 100).toExponential(0)
        },
        wrongAnswersPercentage() {
            if (this.wrongAnswers / this.totalAnswers * 100 === 0)
                return 0;
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
        <h2 class="text-3xl font-semibold leading-loose text-primary text-center">نتيجة الاختبار</h2>
        <div class="flex gap-3 items-center">
            <RadialProgress :completed-steps="correctAnswersPercentage" :diameter="70" :inner-stroke-width="4"
                            :stroke-width="4" :total-steps="100" inner-stroke-color="rgb(209 213 219)"
                            start-color="hsl(142.1 76.2% 36.3%)" stop-color="hsl(142.1 76.2% 36.3%)">
                <p class="m-2">{{ score }}%</p>
            </RadialProgress>
            <p class="leading-loose text-lg text-success">الاجابات الصحيحة:
                <span class="leading-loose text-lg text-success">{{ correctAnswers }}</span>
            </p>
        </div>

        <div class="flex gap-3 items-center">
            <RadialProgress :completed-steps="wrongAnswersPercentage" :diameter="70" :inner-stroke-width="4"
                            :stroke-width="4" :total-steps="100" inner-stroke-color="rgb(209 213 219)"
                            start-color="hsl(0 84.2% 60.2%)" stop-color="hsl(0 84.2% 60.2%)">
                <p class="m-2">{{ wrongAnswersPercentage }}%</p>
            </RadialProgress>
            <p class="leading-loose text-lg text-error">الاجابات الخاطئة: <span class="leading-loose text-lg text-error">{{
                    wrongAnswers
                }}</span></p>
        </div>

        <div class="mt-6 flow-root">
            <button v-if="correctAnswers < 2"
                    class="bg-product-orange w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                    type="button" @click="resetQuiz">
                حاول مرة اخرى
            </button>

            <button v-else
                    class="bg-product-orange w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                    type="button" @click="exitQuiz">
                انهاء الاختبار
            </button>
        </div>
    </div>
</template>
