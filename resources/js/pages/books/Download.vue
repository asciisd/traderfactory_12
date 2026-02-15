<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Flash, type SharedData } from '@/types';
import { type Book } from '@/types/books';
import { Head, router, usePage } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const page = usePage<SharedData>();
const flash = page.props.flash as Flash;

interface Props {
    book: Book;
    downloadUrl: string;
}

const props = defineProps<Props>();

const sendEmailLink = () => {
    router.post(route('books.download', props.book.data.id));
};
</script>

<template>
    <Head title="Downloads" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <div class="flex flex-col items-center">
                            <h1 class="mb-6 text-2xl font-bold">{{ book.name }}</h1>

                            <div
                                v-if="flash.success"
                                class="relative mb-6 w-full rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700"
                            >
                                <span class="block sm:inline">{{ flash.success }}</span>
                            </div>

                            <div v-if="flash.failed" class="relative mb-6 w-full rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                                <span class="block sm:inline">{{ flash.failed }}</span>
                            </div>

                            <div class="flex w-full flex-col md:flex-row">
                                <div class="p-4 md:w-1/3">
                                    <img :src="book.imageSrc" :alt="book.name" class="h-auto w-full rounded shadow-lg" />
                                </div>

                                <div class="p-4 md:w-2/3">
                                    <div class="mb-6">
                                        <h2 class="mb-2 text-xl font-semibold">تفاصيل الكتاب</h2>
                                        <p class="mb-4" v-html="book.description"></p>
                                    </div>

                                    <div class="flex flex-col space-y-4">
                                        <div v-if="downloadUrl" class="flex flex-col space-y-4">
                                            <a
                                                :href="downloadUrl"
                                                target="_blank"
                                                class="rounded bg-blue-600 px-6 py-3 text-center font-bold text-white hover:bg-blue-700"
                                            >
                                                تحميل الكتاب
                                            </a>

                                            <p class="text-sm text-gray-600">
                                                * رابط التحميل صالح لمدة 30 دقيقة فقط. إذا انتهت صلاحية الرابط، يرجى تحديث الصفحة.
                                            </p>
                                        </div>

                                        <div v-else class="text-red-600">ملف الكتاب غير متوفر حالياً. يرجى التواصل مع الدعم الفني.</div>

                                        <div class="mt-4">
                                            <form @submit.prevent="sendEmailLink">
                                                <button
                                                    type="submit"
                                                    class="w-full rounded bg-gray-200 px-4 py-2 text-center font-bold text-gray-800 hover:bg-gray-300"
                                                >
                                                    إرسال رابط التحميل إلى البريد الإلكتروني
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
