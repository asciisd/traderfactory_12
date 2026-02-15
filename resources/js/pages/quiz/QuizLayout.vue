<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="bg-cover bg-no-repeat flex w-full h-screen justify-center items-center bg-gray-200">
        <div class="max-w-xl w-full p-3">
            <slot></slot>
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
