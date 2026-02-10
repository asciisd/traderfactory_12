<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="py-16 md:p-24 bg-fixed bg-cover bg-no-repeat bg-blend-multiply w-full min-h-screen"
         tabindex="0"
         @focus="unselectBoxes">
        <div class="grid grid-cols-1 lg:grid-cols-8 p-4 lg:p-0 lg:gap-4">
            <div class="lg:hidden mb-4">
                <select v-model="selectedBox"
                        class="sticky mt-1 block w-full ps-3 pe-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    <option v-for="option in slideItems" :key="option.id" :value="option">{{ option.title }}</option>
                </select>
            </div>

            <!-- Right Boxes Section -->
            <div
                class="hidden lg:block w-full h-full col-span-2 lg:flex lg:flex-col lg:justify-start lg:items-end lg:gap-4 rounded-md">
                <template v-for="(rightBox, i) in slideItems">
                    <a v-if="!(i%2)"
                       class="rounded-md text-center inline-flex items-center justify-center p-4 w-32 h-32 border border-gray-300 shadow-sm text-base font-medium rounded-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-GoetheBeige-500 focus:bg-GoetheBeige focus:text-white focus:font-semibold"
                       href="#" type="button"
                       @click.prevent="boxSelected(rightBox)">
                        {{ rightBox.title }}
                    </a>
                </template>
            </div>

            <!-- Center Content Section -->
            <div class="lg:p-4 w-full h-auto bg-black bg-opacity-25 col-span-4 rounded-md">
                <div class="p-6 w-full h-full bg-black bg-opacity-50 rounded-md">
                    <div class="text-base max-w-prose mx-auto lg:ms-auto lg:me-0 ">
                        <slot v-if="!selectedBox"></slot>
                        <div v-else class="mt-2 description-light"
                             v-html="selectedBox.description"/>
                    </div>
                </div>
            </div>

            <!-- Left Boxes Section -->
            <div
                class="hidden lg:block w-full h-full col-span-2 lg:flex lg:flex-col lg:justify-start lg:items-start lg:gap-4 rounded-md">
                <template v-for="(leftBox, i) in slideItems">
                    <a v-if="i%2"
                       class="rounded-md text-center inline-flex items-center justify-center p-4 w-32 h-32 border border-gray-300 shadow-sm text-base font-medium rounded-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-GoetheBeige-500 focus:bg-GoetheBeige focus:text-white focus:font-semibold"
                       href="#" type="button"
                       @click.prevent="boxSelected(leftBox)">
                        {{ leftBox.title }}
                    </a>
                </template>
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
        slideItems: {
            type: Array,
            default: []
        },
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
