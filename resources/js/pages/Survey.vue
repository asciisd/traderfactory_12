<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="bg-secondary-600">
        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
          <span class="flex p-2 rounded-lg bg-secondary-800">
            <MegaphoneIcon aria-hidden="true" class="h-6 w-6 text-white"/>
          </span>
                    <p class="ms-3 font-medium text-white truncate">
            <span class="md:hidden">
              يهمنا رأيك جداً
            </span>
                        <span class="hidden md:inline">
              يهمنا رأيك جدا, استطلاع راى خاص بتقييم مهارة تحديد الاحتياج للمعلومات
            </span>
                    </p>
                </div>
                <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
                    <a class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-secondary-600 bg-white hover:bg-secondary-50"
                       href="https://forms.gle/DRHC3NuxTgz3LfKZ6">
                        ابدأ التقييم
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {MegaphoneIcon, XMarkIcon} from '@heroicons/vue/24/outline'

export default {
    components: {
        MegaphoneIcon,
        XMarkIcon,
    },
}
</script>
