<script setup>
import GlossaryTabs from "@/pages/glossary/Partials/GlossaryTabs.vue"
import {MagnifyingGlassIcon} from "@heroicons/vue/24/outline";
import {Link} from "@inertiajs/vue3";
import {computed, ref, onMounted} from "vue";
import Alphabets from "@/pages/glossary/Partials/Alphabets.vue";
import AlphabetResults from "@/pages/glossary/Partials/AlphabetResults.vue";
import TopicBrowser from "@/pages/glossary/Partials/TopicBrowser.vue";
import AppLayout from "@/layouts/AppLayout.vue";

const props = defineProps({
    glossaries: Object
})

const arabicAlphabets = ['أ', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
const selectedTab = ref('tab_1')
const searchInput = ref('');
const selectedLetter = ref(arabicAlphabets[0]); // Default to first alphabet letter
const topicBrowserRef = ref(null);
const selectedTopicLetter = ref('');

// Ensure the first alphabet letter is selected when the page loads
onMounted(() => {
    // Make sure we're on the first tab and the first letter is selected
    if (selectedTab.value === 'tab_1' && !searchInput.value) {
        selectedLetter.value = arabicAlphabets[0];
    }
});

const filteredItems = computed(() => {
    const searchTerm = searchInput.value.toLowerCase().trim();
    if (searchTerm === '') {
        return [];
    } else {
        return props.glossaries.data.filter(item => (item.title).toLowerCase().includes(searchTerm));
    }
});

const handleSearch = (query) => {
    searchInput.value = query;
};

const handleLetterSelected = (letter) => {
    selectedLetter.value = letter;
};

const handleTopicLetterSelected = (letter) => {
    // Set the selected letter without clearing it
    selectedTopicLetter.value = letter;

    // No longer clearing the selection after a delay
    // This ensures the letter stays highlighted when scrolling
};

const handleTabChange = (tab) => {
    selectedTab.value = tab;
    // Reset search when changing tabs
    searchInput.value = '';

    // If switching to the first tab, select the first alphabet letter
    if (tab === 'tab_1') {
        selectedLetter.value = arabicAlphabets[0];
    } else {
        selectedLetter.value = '';
    }

    selectedTopicLetter.value = '';
};

const isSearching = computed(() => {
    return searchInput.value.trim() !== '' || selectedTab.value === 'search';
});

const showAlphabets = computed(() => {
    return selectedTab.value === 'tab_1' && !isSearching.value;
});

const showTopics = computed(() => {
    return selectedTab.value === 'tab_2' && !isSearching.value;
});

// Add a new handler for the letter-scrolled event
const handleLetterScrolled = (letter) => {
    // Only update if the letter is different to prevent unnecessary re-renders
    if (selectedTopicLetter.value !== letter) {
        // Keep the letter selected
        selectedTopicLetter.value = letter;
    }
};

// Add a new handler for the letter-deselected event
const handleLetterDeselected = () => {
    // Only clear if there's a letter selected to prevent unnecessary re-renders
    if (selectedTopicLetter.value) {
        // Clear the selected letter when scrolling away
        selectedTopicLetter.value = '';
    }
};
</script>

<template>
    <AppLayout title="Glossaries">
        <div class="max-w-7xl mx-auto py-6 sm:py-12 bg-white">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-3xl lg:px-8">
                <!-- Sticky header with tabs -->
                <div class="sticky top-16 z-50 bg-white">
                    <GlossaryTabs @update-tab="handleTabChange" @search="handleSearch"/>

                    <!-- Show alphabets when on term tab and not searching -->
                    <div v-if="showAlphabets" class="bg-white border border-gray-200 rounded-b-lg p-4">
                        <Alphabets
                            :glossaries="glossaries.data"
                            :sticky-alphabet="true"
                            :show-alphabet-bar="true"
                            :external-selected-letter="selectedLetter"
                            @letter-selected="handleLetterSelected"
                        />
                    </div>

                    <!-- Show topic alphabets when on topic tab and not searching -->
                    <div v-if="showTopics" class="bg-white border border-gray-200 rounded-b-lg p-4">
                        <div class="flex justify-center flex-wrap">
                            <button v-for="letter in arabicAlphabets" :key="letter"
                                    :class="[
                                        letter === selectedTopicLetter
                                            ? 'bg-secondary text-white'
                                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200',
                                        'mt-2 mx-1 h-8 w-8 inline-flex items-center justify-center duration-300 text-sm'
                                    ]"
                                    @click="handleTopicLetterSelected(letter)">
                                {{ letter }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Content area -->
                <div class="mt-4 bg-white border border-gray-200 rounded-lg p-4 sm:p-8">
                    <!-- Show topics when on topic tab and not searching -->
                    <TopicBrowser
                        v-if="showTopics"
                        ref="topicBrowserRef"
                        :glossaries="glossaries.data"
                        :selected-letter="selectedTopicLetter"
                        @letter-scrolled="handleLetterScrolled"
                        @letter-deselected="handleLetterDeselected"
                    />

                    <!-- Show alphabet results when on term tab and not searching -->
                    <div v-if="showAlphabets">
                        <AlphabetResults
                            :glossaries="glossaries.data"
                            :selected-letter="selectedLetter"
                        />
                    </div>

                    <!-- Show search results when searching or search tab is active -->
                    <div v-if="isSearching">
                        <h3 class="text-lg font-medium text-gray-900 mb-4" v-if="searchInput.trim()">نتائج البحث عن: "{{ searchInput }}"</h3>
                        <h3 class="text-lg font-medium text-gray-900 mb-4" v-else>البحث في المصطلحات</h3>

                        <ul v-if="filteredItems.length > 0" role="list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <li v-for="glossary in filteredItems" :key="glossary.id" class="py-1">
                                <Link :href="route('glossary.show', glossary)"
                                      class="text-primary hover:text-primary-700 hover:underline">
                                    {{ glossary.title }}
                                </Link>
                            </li>
                        </ul>
                        <div v-else-if="searchInput.trim()" class="text-center py-8 text-gray-500">
                            <MagnifyingGlassIcon class="h-12 w-12 mx-auto text-gray-400 mb-4" />
                            لا توجد نتائج مطابقة لـ "{{ searchInput }}"
                        </div>
                        <div v-else class="text-center py-8 text-gray-500">
                            ابدأ البحث عن المصطلحات...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
/* Add some space at the bottom of the page to prevent content from being hidden behind the sticky header */
body {
    padding-bottom: 2rem;
    background-color: white;
}

/* Ensure sticky elements work properly */
.sticky {
    position: -webkit-sticky;
    position: sticky;
}
</style>
