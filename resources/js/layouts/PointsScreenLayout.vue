<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="bg-fixed bg-cover bg-no-repeat bg-blend-multiply w-full min-h-screen overflow-scroll">
        <div class="w-full h-full flex justify-evenly flex-col lg:flex-row">
            <div class="w-full h-full">

            </div>
            <div
                class="pt-12 pb-16 px-4 sm:pt-16 sm:px-6 lg:px-8 lg:mx-auto w-full min-h-screen bg-white bg-opacity-75">
                <div class="text-base max-w-prose mx-auto lg:ms-auto lg:me-0 ">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        imageUrl: {
            type: String,
            default: ''
        }
    }
})
</script>
