<template>
    <Link :class="classes" :href="href">
        <slot/>
    </Link>
</template>

<script>
import {defineComponent} from 'vue'

import {Link} from '@inertiajs/vue3';

export default defineComponent({
    components: {
        Link,
    },

    props: ['href', 'active'],

    computed: {
        classes() {
            return 'text-base font-medium text-secondary-800 hover:text-secondary-600'
        }
    }
})
</script>
