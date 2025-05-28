<script setup lang="ts">
import {ArrowLongLeftIcon, HeartIcon} from '@heroicons/vue/24/solid'
import BackMenu from "@/Components/Menu/BackMenu.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue'
import {useForm} from '@inertiajs/vue3'

type Props = {
    section: object,
    favStatus: boolean
}

const props = defineProps<Props>()

const form = useForm({
    section_id: props.section.id
})

const buyForm = useForm({
    course_id: props.section.course_id,
    price: props.section.course_price
})

const addToFav = () => {
    form.put(route('sections.favorites', props.section), {
        preserveScroll: true,
    })
}

const byuCourse = () => {
    buyForm.post(route('orders.create', ['course', props.section.course_id]))
}
</script>

<template>
    <div class="relative bg-primary overflow-hidden">
        <back-menu class="bg-transparent z-50 w-full"/>
        <div class="relative pb-8 sm:pb-16">
            <main class="mt-16 mx-auto max-w-7xl px-4 sm:mt-8 sm:px-6 lg:mt-16">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-start">
                        <h1>
                            <span class="mt-1 block text-2xl tracking-tight font-extrabold sm:text-3xl xl:text-4xl">
                                <span class="block leading-loose text-CarrotOrange">{{ section.title }}</span>
                                <span class="block leading-relaxed text-gray-100">{{ section.description }}</span>
                            </span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl"
                           v-html="section.overview"></p>

                        <div v-if="!section.can.view && !section.course_price === null || !section.course_price <= 0"
                             class="mt-8 text-gray-300 text-lg">
                            <span class="font-bold">السعر:</span>
                            <span class="mr-2 font-normal">{{ section.course_price }}</span>
                            <span class="mr-2 font-bold">{{ $page.props.currency }}</span>
                        </div>

                        <div class="flex justify-between items-ceter mt-8">
                            <div v-if="!section.can.view">
                                <PrimaryButton class="sm:text-lg text-sm" @click="byuCourse">
                                    <span>{{
                                            section.course_price === null || section.course_price <= 0 ? 'ابدأ الدورة' : 'شراء'
                                        }}</span>
                                    <ArrowLongLeftIcon class="h-6 w-6 mr-2 animate-poke"/>
                                </PrimaryButton>
                            </div>

                            <div v-if="$page.props.auth.user" class="flex items-center">
                                <form @submit.prevent="addToFav">
                                    <button :class="[favStatus ? 'text-CarrotOrange' : 'text-gray-200']"
                                            :disabled="form.processing"
                                            type="submit">
                                        <input v-model="form.section_id" type="hidden">
                                        <span class="inline-flex items-center text-sm sm:text-base"><heart-icon
                                            :class="[favStatus ? 'animate-pulse' : 'animate-bounce' ,'h-5 w-5 sm:me-2']"/>{{
                                                favStatus ? 'الغاء من المفضلة' : 'اضف الى المفضلة'
                                            }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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
