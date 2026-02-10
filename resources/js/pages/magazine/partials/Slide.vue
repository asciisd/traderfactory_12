<template>
    <component :is="slide.layout" v-if="slide.layout === 'final-slide-layout'" :image-url="slide.s3_image">
        <div class="flex flex-col justify-end items-center min-h-screen py-24 lg:p-24">
            <div class="flex flex-col lg:flex-row w-full lg:space-x-4 rtl:space-x-reverse space-y-4 lg:space-y-0">
                <div v-for="item in slide.slide_items" class="p-4 w-full h-64 bg-white bg-opacity-75">
                    <h3 class="text-gray-700 text-xl font-bold">
                        {{ item.title }}
                    </h3>
                    <div class="description sm-li" v-html="item.description"/>
                </div>
            </div>
        </div>
    </component>
    <component :is="slide.layout" v-else :image-url="slide.s3_image" :slide-items="slide.slide_items">
        <div>
            <h3 :class="[slide.layout === 'boxes-slide-layout' ? 'title-light' : 'title', 'mt-2']"
                v-text="slide.title"/>
            <div :class="[slide.layout === 'boxes-slide-layout' ? 'description-light' : 'description', 'mt-8']">
                <div v-html="slide.description"/>
            </div>
        </div>
    </component>
</template>

<script>
import {defineComponent} from "vue";
import HalfScreenLayout from '@/layouts/HalfScreenLayout.vue'
import RightHalfScreenLayout from '@/layouts/RightHalfScreenLayout.vue'
import LeftHalfScreenLayout from '@/layouts/LeftHalfScreenLayout.vue'
import BoxesSlideLayout from "@/layouts/BoxesSlideLayout.vue";
import FinalSlideLayout from "@/layouts/FinalSlideLayout.vue";
import {Head} from '@inertiajs/vue3'

export default defineComponent({
    props: ['slide'],
    components: {
        Head,
        HalfScreenLayout,
        RightHalfScreenLayout,
        LeftHalfScreenLayout,
        BoxesSlideLayout,
        FinalSlideLayout,
    },
})
</script>
