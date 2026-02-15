<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="bg-fixed bg-cover bg-no-repeat bg-blend-multiply w-full min-h-screen overflow-scroll">
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
