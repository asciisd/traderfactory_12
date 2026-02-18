<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <button
        class="lg:max-w-md lg:mb-12 col-span-2 w-full inline-flex justify-center lg:rounded-md border border-transparent shadow-sm px-4 py-2 bg-product-orange text-base font-medium text-white hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
        type="button"
        @click="startTodo">
        مارس بنفسك
    </button>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    emits: ['startTodo'],
    props: {
        title: {
            type: String,
            default: ''
        }
    },
    methods: {
        startTodo() {
            this.$emit('startTodo')
        }
    }
})
</script>
