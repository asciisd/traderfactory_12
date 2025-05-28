<script setup lang="ts">
import { Button } from '@/components/ui/button';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Books } from '@/types/books';
import { Head, router } from '@inertiajs/vue3';
import { watch } from 'vue';
import { toast, Toaster } from 'vue-sonner';

interface Props {
    books: Books;
    flash: {
        success: string;
    };
}

const props = defineProps<Props>();

watch(
    () => props.flash.success,
    (newValue) => {
        if (newValue !== null) {
            toast.success(newValue);
        }
    },
);

const buyFreeBook = (book_id: number) => {
    router.post(route('orders.create', ['book', book_id]));
};

const buyBook = (book_id: number) => {
    router.post(route('orders.create', ['book', book_id]));
};
</script>

<template>
    <GuestLayout>
        <Head title="Books" />
        <Toaster position="top-right" dir="auto" />
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <main>
                    <div class="max-w-7xl">
                        <div class="rounded-lg">
                            <div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 sm:py-16 lg:max-w-7xl lg:px-8">
                                <div class="mt-16 space-y-24">
                                    <div
                                        v-for="book in books.data"
                                        :key="book.name"
                                        class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-8"
                                    >
                                        <div class="col-span-6 mt-6 space-y-6 p-4 text-center md:text-right lg:mt-0">
                                            <h3 class="text-2xl font-bold">{{ book.name }}</h3>
                                            <div class="text-md mt-2 space-y-2 font-medium" v-html="book.description"></div>
                                            <div v-if="book.price > 0" class="mt-8 text-lg">
                                                <span class="font-bold">السعر:</span>
                                                <span class="mr-2 font-normal">{{ book.price }}</span> EGP
                                            </div>

                                            <!-- Download button for owned books or free books -->
                                            <Button v-if="book.isOwned" as="a" :href="book.downloadUrl"> تحميل الكتاب </Button>

                                            <!-- Free books that are not yet owned -->
                                            <Button class="cursor-pointer" v-else-if="book.price <= 0" @click="buyFreeBook(book.id)"
                                                >تحميل الكتاب المجاني</Button
                                            >

                                            <!-- Buy button for paid books that are not owned -->
                                            <Button class="cursor-pointer" v-else-if="book.price > 0" @click="buyBook(book.id)"> شراء الكتاب </Button>
                                        </div>
                                        <div class="col-span-4 col-start-8 flex h-full items-center justify-center">
                                            <div class="relative overflow-hidden lg:w-full">
                                                <img :alt="book.imageAlt" :src="book.imageSrc" class="mx-auto rounded-lg shadow-xl lg:w-full" />
                                                <span
                                                    v-if="book.price <= 0"
                                                    class="absolute top-4 -right-16 z-20 w-48 rotate-45 rounded bg-green-300 px-2 py-1 text-center text-gray-700 shadow-xl"
                                                >
                                                    {{ 'مجانا' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </GuestLayout>
</template>
