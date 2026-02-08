<template>
    <div>
        <div v-show="selectedLetter" class="my-6 flex items-center">
            <span class="text-2xl me-2">📚</span>
            <span>المصطلحات التي تبدأ بـ </span>
            <strong>"{{ selectedLetter }}"</strong>
        </div>
        <ul v-if="filteredTerms.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" role="list">
            <li v-for="glossary in filteredTerms" :key="glossary.id" class="py-1">
                <Link :href="route('glossary.show', glossary)"
                      class="text-primary hover:text-primary-700 hover:underline">
                    {{ glossary.title }}
                </Link>
            </li>
        </ul>
        <div v-else-if="selectedLetter" class="text-center py-8 text-gray-500">
            <span class="text-2xl block mb-2">🔍</span>
            لا توجد مصطلحات تبدأ بـ "{{ selectedLetter }}"
        </div>
        <div v-else class="text-center py-8 text-gray-500">
            <span class="text-2xl block mb-2">👆</span>
            اختر حرفًا من الأبجدية لعرض المصطلحات
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue';
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    glossaries: {
        type: Array,
        required: true
    },
    selectedLetter: {
        type: String,
        default: ''
    }
});

const filteredTerms = computed(() => {
    if (!props.selectedLetter) {
        return [];
    }
    return props.glossaries.filter(glossary => glossary.initial === props.selectedLetter);
});
</script> 