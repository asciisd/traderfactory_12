<script setup lang="ts">
import { type Section } from '@/types/courses';
import { Link } from '@inertiajs/vue3';
import { ClockIcon } from 'lucide-vue-next';

interface Props {
    section: Section;
}

const props = defineProps<Props>();

const isFreeCourse = () => {
    return props.section.course_price <= 0;
};
</script>

<template>
    <Link :key="section.name" :href="route('courses.sections.section', section.slug)">
        <div
            :class="[
                section.color === '' ? 'hover:bg-yellow-300' : `hover:${section.color}`,
                'group relative flex gap-8 overflow-hidden rounded-xl bg-white shadow-xl transition duration-200 ease-in hover:scale-105 hover:shadow-2xl sm:w-72 sm:flex-col sm:justify-between md:w-full xl:w-auto',
            ]"
        >
            <span
                :class="[
                    isFreeCourse() ? 'bg-green-300' : 'bg-yellow-300',
                    'absolute top-4 -right-16 z-20 w-48 rotate-45 rounded px-2 py-1 text-center text-gray-700 shadow-xl',
                ]"
            >
                {{ isFreeCourse() ? 'مجانا' : 'مدفوع' }}
            </span>
            <img
                :alt="section.image_alt"
                :src="section.s3_image"
                class="h-36 w-28 object-contain object-center p-4 sm:h-60 sm:w-full sm:object-top sm:px-12 sm:pt-12"
            />
            <div class="flex flex-1 flex-col justify-center sm:justify-between sm:p-8">
                <div class="flex justify-between">
                    <h3 class="line-clamp text-lg leading-6 font-medium text-gray-900 group-hover:text-white">
                        {{ section.name }}
                    </h3>
                </div>
                <div class="mt-4 flex gap-2 text-sm text-gray-500 duration-200 ease-in group-hover:text-white sm:gap-4">
                    <ClockIcon class="h-4 w-4 fill-current" />

                    <p>{{ section.duration }}</p>
                    <p>•</p>
                    <p>{{ section.lessons_count + ' دروس' }}</p>
                </div>
            </div>
        </div>
    </Link>
</template>
