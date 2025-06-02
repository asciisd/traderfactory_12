<script setup lang="ts">
import { Button } from '@/components/ui/button/index';
import { Section } from '@/types/courses';
import { MoveLeftIcon, HeartIcon } from 'lucide-vue-next';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    section: Section;
    favStatus: boolean | null;
}

const props = defineProps<Props>();

const form = useForm({
    section: props.section.slug,
});

const buyForm = useForm({
    course_id: props.section.course_id,
    price: props.section.course_price,
});

const addToFav = () => {
    form.put(route('sections.favorites', props.section.slug), {
        preserveScroll: true,
    });
};

const byuCourse = () => {
    buyForm.post(route('orders.create', ['course', props.section.course_id]));
};
</script>

<template>
    <Head :title="section.description" />
    <div class="prose">
            <h1>
                <span class="mt-1 block text-2xl font-extrabold tracking-tight sm:text-3xl xl:text-4xl">
                    <span class="text-primary block leading-loose">{{ section.title }}</span>
                    <span class="block leading-relaxed">{{ section.description }}</span>
                </span>
            </h1>
            <p class="mt-3 text-base sm:mt-5 sm:text-xl lg:text-lg xl:text-xl" v-html="section.overview"></p>

            <div v-if="(!section.can?.view && !section.course_price === null)" class="mt-8 text-lg">
                <span class="font-bold">السعر:</span>
                <span class="mr-2 font-normal">{{ section.course_price }}</span>
                <span class="mr-2 font-bold">{{ $page.props.currency }}</span>
            </div>

            <div class="mt-8 flex items-center justify-between">
                <div v-if="!section.can?.view">
                    <Button class="text-sm sm:text-lg" @click="byuCourse">
                        <span>{{ section.course_price === null || section.course_price <= 0 ? 'ابدأ الدورة' : 'شراء' }}</span>
                        <MoveLeftIcon class="animate-poke mr-2 h-6 w-6" />
                    </Button>
                </div>

                <div v-if="$page.props.auth.user" class="flex items-center">
                    <form @submit.prevent="addToFav">
                        <Button variant="outline"
                            :class="{'text-product-pink': favStatus}"
                            :disabled="form.processing"
                            type="submit">
                            <input v-model="form.section" type="hidden" />
                            <span class="inline-flex items-center text-sm sm:text-base">
                                <HeartIcon :class="[favStatus ? 'fill-product-pink' : 'animate-bounce', 'h-5 w-5 sm:me-2']" />
                                {{ favStatus ? 'إلغاء من المفضلة' : 'اضف الى المفضلة' }}
                            </span>
                        </Button>
                    </form>
                </div>
            </div>
        </div>
</template>
<style>
.animate-poke {
    animation: poke 1s infinite;
}

@keyframes poke {
    0%,
    100% {
        transform: translateX(-25%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }

    50% {
        transform: translateX(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}
</style>
