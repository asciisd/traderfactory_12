<script setup lang="ts">
import { Card, CardContent, CardDescription, CardTitle } from '@/components/ui/card';
import { Course } from '@/types/courses';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { computed, ref } from 'vue';
import { ClockIcon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

interface Props {
    courses: Course[];
}

const props = defineProps<Props>();

const search = ref('');

const filteredCourses = computed(() => {
    return {
        sections: props.courses.filter((item) => {
            return (
                item.title.toLowerCase().indexOf(search.value.toLowerCase()) > -1 ||
                item.description.toLowerCase().indexOf(search.value.toLowerCase()) > -1
            );
        }),
    };
});
</script>

<template>
    <div class="relative my-8 flex justify-center lg:my-12 lg:gap-8">
        <div class="max-w-2xl flex-1 md:px-8 lg:px-0 xl:col-span-6">
            <div class="flex items-center px-6 py-4 md:mx-auto md:max-w-2xl lg:mx-0 lg:max-w-3xl xl:px-0">
                <div class="w-full">
                    <label class="sr-only" for="search">بحث</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                            <MagnifyingGlassIcon aria-hidden="true" class="text-primary h-5 w-5" />
                        </div>
                        <input
                            id="search"
                            v-model="search"
                            class="text-md block h-12 w-full rounded-full border border-gray-300 bg-gray-200 py-2 ps-10 pe-3 placeholder-gray-500 focus:border-pink-500 focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-pink-500 focus:outline-none"
                            name="search"
                            placeholder="ماذا ستتعلم اليوم؟"
                            type="search"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="scrollbar-hide overflow-x-auto py-16 lg:mx-auto lg:max-w-7xl lg:px-8 min-h-screen">
        <div class="grid grid-cols-1 gap-6 px-4 sm:grid-cols-2 md:px-8 lg:grid-cols-3 lg:px-0">
            <Card v-for="course in filteredCourses.sections" :key="course.slug" :class="['relative group cursor-pointer hover:scale-105 duration-200 hover:text-white overflow-hidden', `hover:${course.sections[0].color}`]">
                <Link :href="route('courses.sections.section', course.slug)" preserve-state preserve-scroll>
                <div class="absolute z-[70] -right-16 w-48 rotate-45 rounded px-2 py-1 text-center text-gray-700 shadow-xl group-hover:text-white"
                :class="course.sections[0].is_free ? 'bg-green-300' : 'bg-yellow-300'">
                    <p class="text-sm font-bold">{{ course.sections[0].is_free ? 'مجانا' : 'مدفوع' }}</p>
                </div>
                <CardContent class="flex items-center space-x-4 sm:flex-col sm:items-start">
                    <img
                        :alt="course.sections[0].image_alt"
                        :src="course.sections[0].s3_image"
                        class="sm:h-36 w-28 object-contain object-center p-4 sm:h-60 sm:w-full sm:object-top sm:px-12 sm:pt-12"
                    />
                    <div class="w-full">
                        <CardTitle>{{ course.sections[0].title }}</CardTitle>
                        <CardDescription class="mt-4 flex items-center gap-2 group-hover:text-white">
                            <ClockIcon class="h-4 w-4" />

                            <p>{{ course.sections[0].duration }}</p>
                            <p>•</p>
                            <p>{{ course.sections[0].lessons_count + ' دروس' }}</p>
                        </CardDescription>
                    </div>
                </CardContent>
                </Link>
            </Card>
        </div>
    </div>
</template>
