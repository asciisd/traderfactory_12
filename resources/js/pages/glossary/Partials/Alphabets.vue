<template>
    <div>
        <div v-if="showAlphabetBar" class="flex justify-center flex-wrap p-4">
            <button v-for="letter in arabicAlphabets" :key="letter" 
                    :class="[
                        letter === selectedLetter 
                            ? 'bg-secondary text-white' 
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200', 
                        'mt-2 mx-1 h-8 w-8 inline-flex items-center justify-center duration-300 text-sm'
                    ]"
                    @click="filterStrings(letter)">
                {{ letter }}
            </button>
        </div>
        <div v-show="selectedLetter.length && !stickyAlphabet" class="my-6">
            <span>المصطلحات التي تبدأ بـ </span>
            <strong>"{{ selectedLetter }}"</strong>
        </div>
        <ul v-if="filteredStrings.length && !stickyAlphabet" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" role="list">
            <li v-for="glossary in filteredStrings" :key="glossary.id" class="py-1">
                <Link :href="route('glossary.show', glossary)"
                      class="text-primary hover:text-primary-700 hover:underline">
                    {{ glossary.title }}
                </Link>
            </li>
        </ul>
        <div v-else-if="selectedLetter.length && !stickyAlphabet">لا يوجد</div>
    </div>
</template>

<script setup>
import {computed, ref, watch} from 'vue';
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    glossaries: Object,
    stickyAlphabet: {
        type: Boolean,
        default: false
    },
    showAlphabetBar: {
        type: Boolean,
        default: true
    },
    externalSelectedLetter: {
        type: String,
        default: ''
    }
})

const arabicAlphabets = ['أ', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
const selectedLetter = ref('');

// Watch for changes from parent component
watch(() => props.externalSelectedLetter, (newValue) => {
    selectedLetter.value = newValue;
}, { immediate: true });

const filteredStrings = computed(() => {
    if (selectedLetter.value === '') {
        return props.glossaries
    }
    return props.glossaries.filter((glossary) => glossary.initial === selectedLetter.value);
});

const filterStrings = (letter) => {
    selectedLetter.value === letter ? selectedLetter.value = '' : selectedLetter.value = letter;
    
    // Emit the selected letter to parent component
    emit('letter-selected', selectedLetter.value);
};

const emit = defineEmits(['letter-selected']);
</script>
