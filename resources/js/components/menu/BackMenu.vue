<template>
    <div
        class="flex justify-end mx-auto px-4 py-6 sm:px-6">
        <div>
            <Link :href="route('welcome')" class="flex">
                <span class="sr-only">Traderfactory</span>
                <span class="me-2 text-gray-200">الرجوع للرئيسية</span>
                <ArrowLongLeftIcon class="h-8 w-auto text-secondary"/>
            </Link>
        </div>
    </div>
</template>

<script>
import {ArrowLongLeftIcon} from '@heroicons/vue/24/outline'
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/vue3';

export default defineComponent({
    components: {
        Head,
        Link,
        ArrowLongLeftIcon,
    }
})
</script>
