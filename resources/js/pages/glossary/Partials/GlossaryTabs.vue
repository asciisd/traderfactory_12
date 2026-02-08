<template>
    <div>
        <div class="sm:hidden">
            <label class="sr-only" for="tabs">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select id="tabs" class="block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 mb-4" name="tabs"
                    @change="handleMobileTabChange($event.target.value)">
                <option v-for="tab in tabs" :key="tab.name" :selected="tab.current" :value="tab.value">
                    {{ tab.name }}
                </option>
                <option value="search" :selected="isSearchTabActive">بحث</option>
            </select>
            
            <!-- Mobile search input - only shown when search tab is active -->
            <div v-if="isSearchTabActive" class="mb-4">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                    </div>
                    <input 
                        id="mobile-search" 
                        v-model="searchQuery" 
                        class="block w-full border-gray-300 pl-10 pr-3 py-2 text-gray-900 placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                        placeholder="ابحث عن المصطلحات..." 
                        type="search"
                        @input="emitSearch"
                        ref="mobileSearchInput"
                    />
                </div>
            </div>
        </div>
        <div class="hidden sm:block">
            <!-- Tab container with padding for spacing -->
            <div class="border-b border-gray-200 mb-4">
                <div aria-label="Tabs" class="isolate flex w-full gap-2">
                    <div v-for="(tab, tabIdx) in tabs" :key="tab.name" :aria-current="tab.current ? 'page' : undefined"
                         :class="[
                            tab.current 
                                ? 'text-gray-900 bg-white border border-gray-200 border-b-0 rounded-t-lg relative z-10' 
                                : 'text-gray-500 hover:text-gray-700 bg-gray-100 rounded-t-lg', 
                            'group relative min-w-0 flex-1 overflow-hidden py-4 px-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10 cursor-pointer'
                         ]"
                         @click="switchTab(tabIdx)">
                        <span>{{ tab.name }}</span>
                    </div>
                    
                    <!-- Search tab -->
                    <div 
                        class="relative flex-1 flex items-center px-3 cursor-pointer group rounded-t-lg"
                        :class="[isSearchTabActive 
                            ? 'text-gray-900 bg-white border border-gray-200 border-b-0 relative z-10' 
                            : 'text-gray-500 hover:text-gray-700 bg-gray-100']"
                        @click="activateSearchTab"
                    >
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                        </div>
                        <input 
                            id="search-tab" 
                            v-model="searchQuery" 
                            class="block w-full border-0 py-1.5 pl-10 pr-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm bg-transparent"
                            placeholder="ابحث عن المصطلحات..." 
                            type="search"
                            @input="emitSearch"
                            @click="handleInputClick"
                            @focus="activateSearchTab"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {reactive, ref, computed, watch, nextTick} from 'vue';
import {MagnifyingGlassIcon} from "@heroicons/vue/24/outline";

const emits = defineEmits(['updateTab', 'search'])

const tabs = reactive([
    {name: 'تصفح حسب المصطلح', value: 'tab_1', current: true},
    {name: 'تصفح حسب الموضوع', value: 'tab_2', current: false},
])

const searchQuery = ref('');
const isSearchTabActive = ref(false);
const mobileSearchInput = ref(null);

// Handle mobile tab change
const handleMobileTabChange = (value) => {
    if (value === 'search') {
        activateSearchTab();
        // Focus the search input after it's rendered
        nextTick(() => {
            if (mobileSearchInput.value) {
                mobileSearchInput.value.focus();
            }
        });
    } else {
        tabs.forEach((tab) => {
            tab.current = tab.value === value;
        });
        isSearchTabActive.value = false;
        searchQuery.value = '';
        emits('search', '');
    }
    emits('updateTab', value);
};

const switchTab = (tabIdx) => {
    tabs.forEach((tab) => {
        tab.current = false;
    });
    tabs[tabIdx].current = true;
    isSearchTabActive.value = false;
    
    // Reset search query when switching tabs
    searchQuery.value = '';
    emits('search', '');
    
    emits('updateTab', tabs[tabIdx].value);
};

const activateSearchTab = () => {
    tabs.forEach((tab) => {
        tab.current = false;
    });
    isSearchTabActive.value = true;
    emits('updateTab', 'search');
};

const handleInputClick = (event) => {
    // Prevent the click from bubbling up to the parent div
    event.stopPropagation();
    // Activate the search tab
    activateSearchTab();
};

const emitSearch = () => {
    if (searchQuery.value && !isSearchTabActive.value) {
        activateSearchTab();
    }
    emits('search', searchQuery.value);
};
</script>
