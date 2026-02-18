<template>
    <div v-if="todoBegin">
        <half-screen-layout :is="todo.layout" class="bg-GoetheBeige">

            <!-- Right side code -->
            <template v-slot:right-side>
                <div class="mt-12 lg:p-12">
                    <button ref="trueButtonPressed"
                            class="col-span-2 lg:rounded-lg w-full inline-flex justify-center border border-transparent shadow-sm px-4 py-2 bg-secondary-600 text-base font-semibold text-white hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 sm:text-md"
                            type="button" @click="showTodo(1)">
                        {{ todo.data.title }}
                    </button>
                </div>
            </template>

            <!-- Left side code -->
            <div class="description" v-html="todo.data.description"/>
        </half-screen-layout>
    </div>

    <TodoLayout v-else :image-url="todo.data.s3_image">
        <TransitionRoot
            :show="!todoBegin"
            appear
            as="template"
            enter="transform transition duration-[1500ms]"
            enter-from="opacity-0 rotate-[-120deg] scale-50"
            enter-to="opacity-100 rotate-0 scale-100"
            leave="transform duration-200 transition ease-in-out"
            leave-from="opacity-100 rotate-0 scale-100 "
            leave-to="opacity-0 scale-95 ">

            <StartTodo @startTodo="todoBegin = true"/>

        </TransitionRoot>
    </TodoLayout>
</template>

<script>
import {defineComponent} from "vue";
import StartTodo from "./StartTodo.vue"
import TodoLayout from "@/layouts/TodoLayout.vue";
import HalfScreenLayout from '@/layouts/HalfScreenLayout.vue'
import {TransitionRoot} from "@headlessui/vue";
import LessonLayout from "@/layouts/LessonLayout.vue";
import {useForm} from "@inertiajs/vue3";

export default defineComponent({
    layout: LessonLayout,
    props: {
        todo: {
            type: Object,
            default: {},
            required: true
        }
    },
    data() {
        return {
            todoBegin: false
        }
    },
    methods: {
        showTodo(page) {
        }
    },
    components: {TodoLayout, HalfScreenLayout, StartTodo, TransitionRoot},
    beforeUnmount() {
        if (this.todo.user_progress < 100) {
            useForm({
                user_progress: 100,
            }).put(route('todos.progress', this.todo), {
                preserveScroll: true,
            })
        }
    }
})
</script>
