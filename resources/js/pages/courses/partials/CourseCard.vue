<script setup lang="ts">
import { Card, CardContent, CardDescription, CardTitle } from '@/components/ui/card';
import { Course } from '@/types/courses';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { computed, ref, reactive } from 'vue';
import { ClockIcon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

interface Props {
    courses: Course[];
}

const props = defineProps<Props>();

const sectionSearch = reactive({});

const filteredCourses = computed(() => {
    return props.courses.map(course => {
        const searchValue = sectionSearch[course.id] || '';
        const filteredSections = course.sections.filter(section =>
            section.title.toLowerCase().includes(searchValue.toLowerCase())
        );
        return { ...course, filteredSections };
    });
});
</script>

<template>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div v-for="course in filteredCourses" :key="course.id" class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">{{ course.title }}</h2>
                <div class="relative w-72">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <MagnifyingGlassIcon aria-hidden="true" class="text-primary h-5 w-5" />
                    </div>
                    <input
                        :id="'section-search-' + course.id"
                        v-model="sectionSearch[course.id]"
                        class="text-md block h-10 w-full rounded-full border border-gray-300 bg-gray-200 py-2 ps-10 pe-3 placeholder-gray-500 focus:border-pink-500 focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-pink-500 focus:outline-none"
                        :placeholder="'ابحث في محتوى ' + course.title"
                        type="search"
                    />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                <Card v-for="section in course.filteredSections" :key="section.id" :class="['relative group cursor-pointer hover:scale-105 duration-200 hover:text-white overflow-hidden', `hover:${section.color || ''}`]">
                    <Link :href="route('courses.sections.section', section.slug)" preserve-state preserve-scroll>
                        <div class="absolute z-[70] -right-16 w-48 rotate-45 rounded px-2 py-1 text-center text-gray-700 shadow-xl group-hover:text-white"
                        :class="section.is_free ? 'bg-green-300' : 'bg-yellow-300'">
                            <p class="text-sm font-bold">
                                {{ section.is_free ? 'مجانا' : 'مدفوع' }}
                            </p>
                        </div>
                        <CardContent class="flex items-center space-x-4 sm:flex-col sm:items-start">
                            <img
                                :alt="section.image_alt"
                                :src="section.s3_image"
                                class="sm:h-36 w-28 object-contain object-center p-4 sm:h-60 sm:w-full sm:object-top sm:px-12 sm:pt-12"
                            />
                            <div class="w-full">
                                <CardTitle>{{ section.title }}</CardTitle>
                                <CardDescription class="mt-4 flex items-center gap-2 group-hover:text-white">
                                    <ClockIcon class="h-4 w-4" />
                                    <p>{{ section.duration }}</p>
                                    <p>•</p>
                                    <p>{{ section.lessons_count + ' دروس' }}</p>
                                </CardDescription>
                            </div>
                        </CardContent>
                    </Link>
                </Card>
            </div>
        </div>
    </div>
</template>
