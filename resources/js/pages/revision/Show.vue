<template>
    <full-background-screen-layout :background-url="revision.s3_image">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-8 lg:gap-8 p-4 lg:mx-12 lg:pt-24 pt-16">
            <div class="hidden lg:block grid grid-rows-1 gap-3 col-span-1">
                <RadioGroup v-model="groupSelected">
                    <div class="grid grid-cols-1 gap-3">
                        <RadioGroupOption v-for="(option, index) in revision.items" :key="option.id"
                                          v-slot="{ active, checked }"
                                          :value="option"
                                          as="template">
                            <div
                                :class="[active ? 'ring-2 ring-offset-2 ring-primary' : '', checked ? 'bg-primary-600 border-transparent text-white hover:bg-primary-700' : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50', 'cursor-pointer focus:outline-none border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium sm:flex-1']">
                                <RadioGroupLabel as="p">
                                    {{ option.title }}
                                </RadioGroupLabel>
                            </div>
                        </RadioGroupOption>
                    </div>
                </RadioGroup>
            </div>

            <div class="lg:hidden">
                <select v-model="groupSelected"
                        class="sticky mt-1 block w-full ps-3 pe-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                    <option v-for="(option, index) in revision.items" :key="option.id" :value="option">
                        {{ option.title }}
                    </option>
                </select>
            </div>

            <div v-if="groupSelected" class="h-full w-full bg-white p-12 rounded-lg col-span-2">
                <h3 class="title mt-2" v-text="groupSelected.title"/>
                <div class="description mt-8" v-html="groupSelected.description"/>
            </div>

        </div>
    </full-background-screen-layout>
</template>

<script>
import {RadioGroup, RadioGroupLabel, RadioGroupOption} from '@headlessui/vue'
import FullBackgroundScreenLayout from "@/layouts/FullBackgroundScreenLayout.vue";
import LessonLayout from "@/layouts/LessonLayout.vue";
import {useForm} from "@inertiajs/vue3";

export default {
    layout: LessonLayout,
    props: {
        revision: {
            type: Object,
            default: {},
            required: true
        }
    },
    data() {
        return {
            groupSelected: this.revision.data.items[0],
            currentPage: 1,
            userProgress: 0.0
        }
    },
    components: {
        FullBackgroundScreenLayout, RadioGroup,
        RadioGroupLabel,
        RadioGroupOption,
    },
    computed: {
        totalPages() {
            return this.revision.items.length;
        },
        pageIndex() {
            return this.currentPage - 1;
        },
        progress() {
            return (this.currentPage / this.totalPages * 100);
        }
    },
    watch: {
        groupSelected: function (newVal, oldVal) {
            let newIndex = this.revision.items.indexOf(newVal)
            console.log(newIndex);
            this.markComplete(newIndex);
        }
    },
    methods: {
        pageChanged(page) {
            this.currentPage = page;
            this.incrementUserProgress();
        },
        incrementUserProgress() {
            if (this.userProgress <= this.progress) {
                this.userProgress = this.progress;
            }
        },
        markComplete(index) {
            console.log('Index : ' + index + ' Checked.');
            this.pageChanged(index + 1)
        }
    },
    beforeUnmount() {
        if (this.revision.user_progress < this.userProgress.toFixed(2)) {
            useForm({
                user_progress: this.userProgress.toFixed(2),
            }).put(route('revisions.progress', this.revision), {
                preserveScroll: true,
            })
        }
    }
}
</script>
