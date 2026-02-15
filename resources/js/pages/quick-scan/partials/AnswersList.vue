<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div>
        <h2 class="text-lg font-semibold text-secondary mb-8">{{ question.question }}</h2>

        <RadioGroup v-model="answer" class="mt-2">
            <RadioGroupLabel class="sr-only">
                {{ question.question }}
            </RadioGroupLabel>
            <div class="grid gap-3">
                <RadioGroupOption v-for="option in question.quick_answers" :key="option.choice"
                                  v-slot="{ active, checked }"
                                  :value="option.choice" as="template" @click="questionAnswer">
                    <div
                        :class="[active ? 'ring-2 ring-offset-2 ring-primary-500' : '', checked ? 'bg-primary-600 border-transparent text-white hover:bg-primary-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50', 'cursor-pointer focus:outline-none border rounded-md py-3 px-3 flex items-center text-sm font-medium uppercase sm:flex-1']">
                        <RadioGroupLabel as="p">
                            {{ option.description }}
                        </RadioGroupLabel>
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>
    </div>
</template>

<script>
import {RadioGroup, RadioGroupLabel, RadioGroupOption, TransitionRoot} from "@headlessui/vue";

export default {
    emits: ['questionAnswer'],
    props: {
        question: {
            type: Object,
            default: null
        },
        oldAnswer: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            answer: this.oldAnswer ?? null
        }
    },
    computed: {
        hasAnswer() {
            return this.answer !== null
        }
    },
    components: {
        RadioGroup,
        TransitionRoot,
        RadioGroupLabel,
        RadioGroupOption,
    },
    methods: {
        questionAnswer() {
            this.$emit('questionAnswer', this.answer)
        }
    }
}
</script>
