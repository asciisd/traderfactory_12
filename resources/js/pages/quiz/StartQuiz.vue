<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="bg-white backdrop-filter backdrop-blur-lg bg-opacity-50 h-72 rounded-lg shadow-lg w-full">
        <div class="rounded-lg w-full h-full flex flex-col justify-center px-12">
            <div class="text-center">
                <div class="text-lg leading-loose font-semibold text-secondary">
                    {{
                        'هذا الاختبار مكون من ' + quiz.data.quantity + '، ويجب عليك الاختيار إذا ما كانت الإجابة صحيحة أم خاطئة.'
                    }}
                </div>
            </div>

            <button ref="trueButtonPressed"
                    class="mt-12 col-span-2 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                    type="button" @click="startQuiz">
                ابدأ الاسئلة
            </button>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    emits: ['startQuiz'],
    props: ['quiz'],
    methods: {
        startQuiz() {
            this.$emit('startQuiz')
        }
    }
})
</script>
