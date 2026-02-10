<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div :style="{backgroundImage: `url(${s3_image})`}"
         class="bg-center bg-cover bg-no-repeat h-72 rounded-t-lg shadow-lg w-full">
        <div class="rounded-t-lg w-full h-full bg-black bg-opacity-50 flex flex-col justify-center px-12">
            <div v-if="hasAnswer">
                <TransitionRoot
                    :show="isRight"
                    appear
                    as="template"
                    enter="transform transition duration-[1200ms]"
                    enter-from="opacity-0 rotate-[-120deg] scale-50"
                    enter-to="opacity-100 rotate-0 scale-100"
                    leave="transform duration-200 transition ease-in-out"
                    leave-from="opacity-100 rotate-0 scale-100 "
                    leave-to="opacity-0 scale-95 ">

                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                        <CheckIcon aria-hidden="true" class="h-10 w-10 text-green-600"/>
                    </div>
                </TransitionRoot>

                <TransitionRoot
                    :show="!isRight"
                    appear
                    as="template"
                    enter="transform transition duration-[1200ms]"
                    enter-from="opacity-0 rotate-[-120deg] scale-50"
                    enter-to="opacity-100 rotate-0 scale-100"
                    leave="transform duration-200 transition ease-in-out"
                    leave-from="opacity-100 rotate-0 scale-100 "
                    leave-to="opacity-0 scale-95 ">

                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <XCircleIcon aria-hidden="true" class="h-10 w-10 text-red-600"/>
                    </div>
                </TransitionRoot>
            </div>
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
                        type="button" @click="answer(1)">
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
                        type="button" @click="answer(0)">
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
                        class="col-span-2 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-secondary-600 text-base font-medium text-white hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 sm:text-sm"
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
        s3_image: '',
        question: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            boolAnswer: null
        }
    },
    components: {
        CheckIcon,
        XCircleIcon,
        TransitionRoot
    },
    methods: {
        answer(boolAnswer) {
            this.boolAnswer = boolAnswer
            this.$emit('questionAnswer', boolAnswer)
        },
        nextQuestion() {
            this.$emit('nextQuestion')
            this.resetQuestion()
        },
        resetQuestion() {
            this.boolAnswer = null
        }
    },
    computed: {
        hasAnswer() {
            return this.boolAnswer !== null
        },
        isRight() {
            return this.boolAnswer === this.question.correct_answer
        }
    }
})
</script>
