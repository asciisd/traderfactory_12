<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="bg-cover bg-no-repeat bg-right flex w-full h-screen justify-center items-end bg-gray-200">
        <slot></slot>
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
