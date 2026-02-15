<template>
    <div :style="{backgroundImage: `url(${question.image})`}"
         class="bg-center bg-cover bg-no-repeat h-72 rounded-t-lg shadow-lg w-full">
        <div class="rounded-t-lg w-full h-full bg-black bg-opacity-50 flex flex-col justify-center px-12">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-semibold text-white">
                    {{ question['question'] }}
                </h3>
            </div>
        </div>
    </div>
    <div class="h-32 flex flex-col justify-center p-12">
        <div class="grid grid-cols-2 gap-3">
            <TransitionRoot
                :show="!hasAnswer"
                appear
                as="template"
                enter="transform transition duration-[400ms] ease-out"
                enter-from="translate-x-4 opacity-0"
                enter-to="translate-x-0 opacity-100">

                <button ref="trueButtonPressed"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                        type="button" @click="answered(true)">
                    صح
                </button>
            </TransitionRoot>

            <TransitionRoot
                :show="!hasAnswer"
                appear
                as="template"
                enter="transform transition duration-[400ms] ease-out"
                enter-from="translate-x-4 opacity-0"
                enter-to="translate-x-0 opacity-100">

                <button ref="falseButtonPressed"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                        type="button" @click="answered(false)">
                    خطأ
                </button>
            </TransitionRoot>

            <TransitionRoot
                :show="hasAnswer"
                appear
                as="template"
                enter="transform transition duration-[800ms] ease-out"
                enter-from="translate-x-12 opacity-0"
                enter-to="translate-x-0 opacity-100">

                <button ref="trueButtonPressed"
                        class="col-span-2 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                        type="button" @click="nextQuestion">
                    التالي
                </button>
            </TransitionRoot>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import {CheckIcon, XCircleIcon} from '@heroicons/vue/24/outline'
import {TransitionRoot} from '@headlessui/vue'

export default defineComponent({
    emits: ["questionAnswer", "nextQuestion"],
    props: {
        question: {
            type: Object,
            default: null
        },
        answer: {
            type: String,
            default: ''
        }
    },
    components: {
        CheckIcon,
        XCircleIcon,
        TransitionRoot
    },
    methods: {
        answered(choice) {
            this.$emit('questionAnswer', choice)
        },
        nextQuestion() {
            this.$emit('nextQuestion')
            this.resetQuestion()
        }
    },
    computed: {
        hasAnswer() {
            return this.answer !== ''
        }
    }
})
</script>

<style scoped>

</style>
