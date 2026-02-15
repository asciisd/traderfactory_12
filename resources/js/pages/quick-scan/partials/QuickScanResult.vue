<script>
import RadialProgress from "vue3-radial-progress";

export default {
    emits: ['resetQuickScan'],
    props: {
        questions: {
            type: Array,
            default: []
        },
        answers: {
            type: Array,
            default: []
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
        resetQuickScan() {
            this.$emit('resetQuickScan');
        },
        exitQuickScan() {
            window.history.back();
        },
        calculateScore() {
            let score = 0;
            for (let i = 0; i < this.questions.length; i++) {
                if (this.questions[i].correct_answer === this.answers[i]) {
                    score = score + 1
                }
            }

            return Math.round((score / this.questions.length) * 100).toFixed(0)
        }
    }
}
</script>

<template>
    <div class="flex flex-col gap-6">
        <h2 class="text-3xl font-semibold leading-loose text-secondary">النتيجة</h2>

        <div class="flex gap-3 items-center">

            <RadialProgress :completed-steps="score" :diameter="70" :inner-stroke-width="4" :stroke-width="4"
                            :total-steps="100" inner-stroke-color="rgb(209 213 219)" start-color="#017ea1"
                            stop-color="#017ea1">
                <p class="m-2">{{ score }}%</p>
            </RadialProgress>
            <div v-if="pass">
                <h3 class="font-semibold text-xl text-primary">مبروك</h3>
                <p class="leading-loose text-sm text-gray-400">لقد قمت باجتياز الاختبار بنجاح</p>
            </div>
            <div v-else>
                <h3 class="font-semibold text-xl text-red-500">حاول مرة اخرى</h3>
                <p class="leading-loose text-sm text-gray-400">يمكنك المحاولة مرة اخرى من خلال الضغط على الزر الموجود
                    بالاسفل.</p>
            </div>
        </div>

        <div class="mt-6 flow-root">
            <button v-if="pass"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                    type="button" @click="exitQuickScan">
                انهاء الاختبار
            </button>
            <button v-else
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm"
                    type="button" @click="resetQuickScan">
                حاول مرة اخرى
            </button>
        </div>
    </div>
</template>
