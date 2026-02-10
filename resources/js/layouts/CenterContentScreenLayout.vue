<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="py-16 md:p-24 bg-fixed bg-cover bg-no-repeat bg-blend-multiply w-full min-h-screen"
         tabindex="0"
         @focus="unselectBoxes">
        <div class="grid grid-cols-1 lg:grid-cols-8">
            <div class="lg:hidden mb-4">
                <select v-model="selectedBox"
                        class="sticky mt-1 block w-full ps-3 pe-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    <option v-for="option in leftBoxes" :key="option.id" :value="option">{{ option.title }}</option>
                    <option v-for="option in rightBoxes" :key="option.id" :value="option">{{ option.title }}</option>
                </select>
            </div>
            <div
                class="hidden lg:block w-full h-full col-span-2 lg:flex lg:flex-col lg:justify-start lg:items-end lg:space-y-1 lg:-ms-4">
                <a v-for="rightBox in rightBoxes"
                   class="text-center inline-flex items-center justify-center p-4 w-32 h-32 border border-gray-300 shadow-sm text-base font-medium rounded-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-GoetheBeige-500 focus:bg-GoetheBeige focus:text-white focus:font-semibold"
                   href="#" type="button"
                   @click.prevent="boxSelected(rightBox)">
                    {{ rightBox.title }}
                </a>
            </div>
            <div class="lg:p-4 w-full h-auto bg-black bg-opacity-25 col-span-4">
                <div class="p-6 w-full h-full bg-black bg-opacity-50">
                    <div class="text-base max-w-prose mx-auto lg:ms-auto lg:me-0 ">
                        <slot v-if="!selectedBox"></slot>
                        <div v-else>
                            <div class="mt-2 text-xl leading-8 font-medium tracking-tight text-white sm:text-2xl">
                                {{ selectedBox.content }}
                            </div>
                            <div v-if="selectedBox.list" class="prose prose-primary mt-8 text-lg text-white">
                                <ul role="list">
                                    <li v-for="item in selectedBox.list" class="ps-6">
                                        {{ item }}
                                    </li>
                                </ul>
                            </div>
                            <div v-if="selectedBox.images">
                                <img v-for="image in selectedBox.images" :src="image"
                                     alt="" class="mt-4 w-full rounded-lg overflow-hidden">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div
                class="hidden lg:block w-full h-full col-span-2 lg:flex-col lg:justify-start lg:items-start lg:space-y-1 lg:space-x-4 rtl:space-x-reverse lg:ms-4">
                <a v-for="leftBox in leftBoxes"
                   class="text-center inline-flex items-center justify-center p-4 w-32 h-32 border border-gray-300 shadow-sm text-base font-medium rounded-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-GoetheBeige-500 focus:bg-GoetheBeige focus:text-white focus:font-semibold"
                   href="#" type="button"
                   @click.prevent="boxSelected(leftBox)">
                    {{ leftBox.title }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        imageUrl: {
            type: String,
            default: ''
        },
        leftBoxes: {
            type: Array,
            default: []
        },
        rightBoxes: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            selectedBox: null
        }
    },
    methods: {
        boxSelected(box) {
            console.log('Box Selected ' + box)
            this.selectedBox = box;
        },
        unselectBoxes() {
            console.log('Boxes UnSelected')
            this.selectedBox = null;
        }
    }
})
</script>
