<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary-400 text-sm font-medium leading-5  focus:outline-none focus:border-primary-700 transition'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5  hover:border-gray-300 focus:outline-none focus:border-gray-300 transition';
});
</script>

<template>
    <Link :class="classes" :href="href">
        <slot/>
    </Link>
</template>
