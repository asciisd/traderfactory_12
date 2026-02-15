<script setup>
defineProps({
    backgroundUrl: {
        type: String,
        default: ''
    }
})
</script>

<template>
    <div :style="{backgroundImage: `url(${backgroundUrl})`}"
         class="bg-fixed bg-cover bg-no-repeat bg-blend-multiply w-full min-h-screen">
        <slot></slot>
    </div>
</template>
