<script setup>
import {Link} from '@inertiajs/vue3';
import {XCircleIcon} from '@heroicons/vue/24/outline'

defineProps({
    slug: {
        type: String,
        required: true
    }
})
</script>

<template>
    <!-- <pre>{{ slug }}</pre> -->
    <div class="fixed flex p-2 top-0 z-10 w-full bg-background bg-opacity-50">
        <div>
            <Link :href="route('courses.sections.section', slug)" class="flex justify-end" replace>
                <span class="sr-only">انهاء</span>
                <XCircleIcon class="h-8 w-auto text-foreground"/>
            </Link>
        </div>
    </div>
</template>
