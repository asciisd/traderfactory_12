<template>
    <GuestLayout title="الأدوات">
        <div class="max-w-5xl mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold mb-8">الأدوات</h1>
            <ul class="list-disc pe-6 space-y-3">
                <li><Link :href="route('tools.position-size')">حساب حجم الصفقة (Position Size)</Link></li>
                <li><Link :href="route('tools.pip-value')">قيمة النقطة (Pip Value)</Link></li>
                <li><Link :href="route('tools.margin-calculator')">حاسبة الهامش (Margin Calculator)</Link></li>
            </ul>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue'
import {Link} from '@inertiajs/vue3'
</script>


