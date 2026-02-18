<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="bg-cover bg-no-repeat bg-right flex w-full h-screen justify-center items-center bg-background">
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
            default: '/img/img.jpg',
        }
    }
})
</script>
