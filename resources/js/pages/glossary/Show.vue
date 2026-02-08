<template>
    <AppLayout title="Glossary">
        <div class="max-w-7xl mx-auto py-12 sm:py-16">
            <div class="bg-white rounded-lg shadow-md">
                <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 sm:py-16 lg:max-w-3xl lg:px-8">

                    <nav class="flex mb-8" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center">
                            <li class="p-0">
                                <div class="flex items-center">
                                    <Link :href="route('glossary.index')"
                                          class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">المصطلحات
                                    </Link>
                                </div>
                            </li>
                            <li class="p-0">
                                <div class="flex items-center">
                                    <ChevronLeftIcon class="h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true"/>
                                    <div class="ml-4 text-sm font-medium text-gray-500">{{ glossary.data.title }}</div>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <!-- Term header -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">{{ glossary.data.title }}</h2>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span v-if="glossary.data.topic" class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ glossary.data.topic }}
                            </span>
                            <span v-if="glossary.data.category" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10">
                                {{ glossary.data.category }}
                            </span>
                        </div>
                    </div>

                    <!-- Term content -->
                    <div class="prose prose-lg max-w-none">
                        <div v-html="glossary.data.body" class="mt-8"></div>
                    </div>

                    <!-- Related terms -->
                    <div v-if="relatedTerms.length > 0" class="mt-12 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">مصطلحات ذات صلة</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <li v-for="term in relatedTerms" :key="term.id" class="py-1">
                                <Link :href="route('glossary.show', term)"
                                      class="text-primary hover:text-primary-700 hover:underline">
                                    {{ term.title }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-12 pt-6 border-t border-gray-200 flex justify-between">
                        <Link v-if="prevTerm" :href="route('glossary.show', prevTerm)"
                              class="inline-flex items-center gap-x-1.5 text-sm font-medium text-primary hover:text-primary-700">
                            <ChevronRightIcon class="h-5 w-5" />
                            <span>{{ prevTerm.title }}</span>
                        </Link>
                        <div v-else></div>

                        <Link v-if="nextTerm" :href="route('glossary.show', nextTerm)"
                              class="inline-flex items-center gap-x-1.5 text-sm font-medium text-primary hover:text-primary-700">
                            <span>{{ nextTerm.title }}</span>
                            <ChevronLeftIcon class="h-5 w-5" />
                        </Link>
                        <div v-else></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/layouts/AppLayout.vue"
import {ChevronLeftIcon, ChevronRightIcon} from "@heroicons/vue/24/outline";
import {Link} from "@inertiajs/vue3";
import { computed } from 'vue';

const props = defineProps({
    glossary: Object,
    allGlossaries: Object
});

// Find the index of the current term
const currentIndex = computed(() => {
    if (!props.allGlossaries || !props.allGlossaries.data) return -1;
    return props.allGlossaries.data.findIndex(item => item.id === props.glossary.data.id);
});

// Get previous and next terms for navigation
const prevTerm = computed(() => {
    if (currentIndex.value <= 0 || currentIndex.value === -1) return null;
    return props.allGlossaries.data[currentIndex.value - 1];
});

const nextTerm = computed(() => {
    if (currentIndex.value === -1 || currentIndex.value >= props.allGlossaries.data.length - 1) return null;
    return props.allGlossaries.data[currentIndex.value + 1];
});

// Get related terms (same topic or category)
const relatedTerms = computed(() => {
    if (!props.allGlossaries || !props.allGlossaries.data) return [];

    return props.allGlossaries.data
        .filter(item =>
            item.id !== props.glossary.data.id &&
            (item.topic === props.glossary.data.topic ||
             item.category === props.glossary.data.category)
        )
        .slice(0, 5); // Limit to 5 related terms
});
</script>
