<template>
    <Link :class="classes" :href="href">
        <slot/>
    </Link>
</template>

<script>
import {defineComponent} from 'vue'

import {Head, Link} from '@inertiajs/vue3';

export default defineComponent({
    components: {
        Head,
        Link,
    },

    props: ['href', 'active'],

    computed: {
        classes() {
            return 'inline-flex items-center px-4 py-2 bg-secondary-800 border border-transparent rounded-md text-base font-medium text-dark hover:bg-secondary-700 active:bg-secondary-900 focus:outline-none focus:border-secondary-900 focus:ring focus:ring-secondary-300 disabled:opacity-25 transition'
        }
    }
})
</script>
