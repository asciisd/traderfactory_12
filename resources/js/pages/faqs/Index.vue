<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';

defineProps({
    faqs: {
        type: Array,
        required: true,
        default: () => []
    }
})
</script>
<template>
    <GuestLayout title="الأسئلة الشائعة">
        <div class="max-w-5xl mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold mb-8">الأسئلة الشائعة</h1>
            <div class="space-y-4">
                <details v-for="item in faqs" :key="item.id" class="group rounded-lg border border-gray-200 p-4">
                    <summary class="cursor-pointer select-none text-lg font-semibold flex items-center justify-between">
                        <span class="text-primary-700">{{ item.question }}</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <div class="mt-3 prose max-w-none text-gray-700 leading-relaxed" v-html="item.answer"></div>
                </details>
            </div>
        </div>
    </GuestLayout>
</template>


