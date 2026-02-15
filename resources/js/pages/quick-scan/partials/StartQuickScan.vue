<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="bg-white bg-center bg-cover bg-no-repeat h-auto rounded-lg shadow-lg w-full py-8">
        <div class="rounded-lg w-full h-full flex flex-col justify-center px-12">
            <div class="text-start">
                <div class="description" v-html="quickScan.info"></div>
                <div class="py-5">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                عدد الاسئلة
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ '٣ أسئلة' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                المدة
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ '٣ دقائق' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                التقييم
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ 'لمجرد المعلومات' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                الموضوع
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ 'من خلال المحتوى' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <button
                class="mt-12 col-span-2 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                type="button"
                @click="startQuickScan">
                اختبر نفسك
            </button>
        </div>
    </div>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    emits: ['startQuickScan'],
    props: ['quickScan'],
    methods: {
        startQuickScan() {
            this.$emit('startQuickScan')
        }
    }
})
</script>
