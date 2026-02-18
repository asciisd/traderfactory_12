<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div>
        <h2 class="text-lg font-semibold text-foreground-500 mb-8">{{ question.question }}</h2>

        <RadioGroup v-model="answer" class="mt-2">
            <RadioGroupLabel class="sr-only">
                {{ question.question }}
            </RadioGroupLabel>
            <div class="grid gap-3">
                <RadioGroupOption v-for="option in question.quick_answers" :key="option.choice"
                                  v-slot="{ active, checked }"
                                  :value="option.choice" as="template" @click="questionAnswer">
                    <div
                        :class="[active ? 'ring-2 ring-offset-2 ring-foreground' : '', checked ? 'bg-foreground border-transparent text-background hover:bg-foreground' : 'bg-background border-foreground text-foreground hover:bg-background', 'cursor-pointer focus:outline-none border rounded-md py-3 px-3 flex items-center text-sm font-medium uppercase sm:flex-1']">
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
