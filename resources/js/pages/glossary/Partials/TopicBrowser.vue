<template>
    <div>
        <!-- Topics sections -->
        <div class="mt-4 space-y-8">
            <!-- Group topics by their initial letter -->
            <div v-for="letter in groupedTopicLetters" :key="letter" class="mb-10">
                <!-- Alphabet letter header with divider beside it -->
                <div :id="`letter-${letter}`" :data-letter="letter" class="letter-header mb-6 flex items-center">
                    <h2 class="text-2xl font-bold text-secondary">{{ letter }}</h2>
                    <div class="flex-grow h-0.5 bg-gray-200 ms-8"></div>
                </div>
                
                <!-- Topics that start with this letter -->
                <div v-for="(topic, index) in getTopicsByLetter(letter)" :key="index" class="mb-6">
                    <div :id="`topic-${topic.id}`" class="flex items-center cursor-pointer" @click="toggleTopic(topic.id)">
                        <h3 class="text-xl font-bold text-gray-900">{{ topic.name }}</h3>
                        <ChevronDownIcon v-if="!expandedTopics.includes(topic.id)" class="h-5 w-5 me-2 text-gray-500" />
                        <ChevronUpIcon v-else class="h-5 w-5 me-2 text-gray-500" />
                    </div>
                    
                    <div v-if="expandedTopics.includes(topic.id)" class="mt-4 transition-all duration-300 ease-in-out">
                        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <li v-for="term in topic.terms" :key="term.id" class="py-1">
                                <Link :href="route('glossary.show', term)"
                                      class="text-primary hover:text-primary-700 hover:underline">
                                    {{ term.title }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- No topics message -->
            <div v-if="topics.length === 0 && selectedLetter" class="text-center py-8 text-gray-500">
                لا توجد موضوعات تبدأ بـ "{{ selectedLetter }}"
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick, computed } from 'vue';
import { Link } from "@inertiajs/vue3";
import { ChevronDownIcon, ChevronUpIcon } from "@heroicons/vue/24/outline";

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

const arabicAlphabets = ['أ', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
const expandedTopics = ref([]);
const topicObservers = ref([]);
const currentVisibleTopics = ref([]);

// Group glossaries by topic
const topics = ref([]);

// Get unique letters from topics for grouping
const groupedTopicLetters = computed(() => {
    const letters = topics.value.map(topic => topic.initial);
    return [...new Set(letters)].sort((a, b) => {
        return arabicAlphabets.indexOf(a) - arabicAlphabets.indexOf(b);
    });
});

// Function to get topics that start with a specific letter
const getTopicsByLetter = (letter) => {
    return topics.value.filter(topic => topic.initial === letter);
};

// Flag to track if selection is happening due to scrolling
const isAutoSelecting = ref(false);

// Watch for changes in selected letter
watch(() => props.selectedLetter, (newLetter) => {
    if (newLetter) {
        // Only scroll to section if the letter was explicitly selected by the user
        // (not auto-selected during scrolling)
        if (!isAutoSelecting.value) {
            scrollToSection(newLetter);
        }
        
        // Emit an event to keep the letter selected in the parent component
        emit('letter-scrolled', newLetter);
    }
});

// Define emits
const emit = defineEmits(['letter-scrolled', 'letter-deselected']);

onMounted(() => {
    // Group glossaries by topic
    const topicMap = {};
    
    props.glossaries.forEach(glossary => {
        const topic = glossary.topic || 'عام'; // Default topic if none provided
        
        if (!topicMap[topic]) {
            topicMap[topic] = {
                id: topic.toLowerCase().replace(/\s+/g, '-'),
                name: topic,
                terms: [],
                initial: topic.charAt(0) // Store the first letter of the topic
            };
        }
        
        topicMap[topic].terms.push(glossary);
    });
    
    // Convert to array and sort alphabetically
    topics.value = Object.values(topicMap).sort((a, b) => a.name.localeCompare(b.name));
    
    // Expand all topics by default
    topics.value.forEach(topic => {
        expandedTopics.value.push(topic.id);
    });
    
    // Setup intersection observers after the DOM has updated
    nextTick(() => {
        setupIntersectionObservers();
    });
});

const setupIntersectionObservers = () => {
    // Clear any existing observers
    topicObservers.value.forEach(observer => observer.disconnect());
    topicObservers.value = [];
    
    // Create a new intersection observer for letter headers
    const letterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // The data-letter attribute contains the letter
            const letter = entry.target.getAttribute('data-letter');
            
            if (entry.isIntersecting) {
                // Letter section is visible
                // Auto-select the alphabet letter when scrolling to a section
                if (letter) {
                    // Set flag to indicate this is an auto-selection from scrolling
                    isAutoSelecting.value = true;
                    emit('letter-scrolled', letter);
                    
                    // Reset the flag after a short delay
                    setTimeout(() => {
                        isAutoSelecting.value = false;
                    }, 100);
                }
            } else {
                // If we're scrolling away from this letter and it's the currently selected one,
                // we might want to deselect it (handled by topic observers)
            }
        });
    }, { threshold: 0.3, rootMargin: '-100px 0px' });
    
    // Create a new intersection observer for topics
    const topicObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const topicId = entry.target.id;
            const topicName = topicId.replace('topic-', '');
            const topic = topics.value.find(t => t.id === topicName);
            
            if (entry.isIntersecting) {
                // Topic is visible
                if (!currentVisibleTopics.value.includes(topicName)) {
                    currentVisibleTopics.value.push(topicName);
                }
            } else {
                // Topic is no longer visible
                const index = currentVisibleTopics.value.indexOf(topicName);
                if (index !== -1) {
                    currentVisibleTopics.value.splice(index, 1);
                }
                
                // If no visible topics match the selected letter, deselect it
                if (currentVisibleTopics.value.length === 0 || 
                    !topics.value.some(t => 
                        currentVisibleTopics.value.includes(t.id) && 
                        t.initial === props.selectedLetter
                    )) {
                    emit('letter-deselected');
                }
            }
        });
    }, { threshold: 0.1 });
    
    // Observe all letter headers
    nextTick(() => {
        // Find all letter headers and observe them
        const letterHeaders = document.querySelectorAll('.letter-header');
        letterHeaders.forEach(header => {
            letterObserver.observe(header);
        });
        
        // Observe all topic elements
        topics.value.forEach(topic => {
            const element = document.getElementById(`topic-${topic.id}`);
            if (element) {
                topicObserver.observe(element);
            }
        });
        
        // Store the observers for cleanup
        topicObservers.value.push(letterObserver, topicObserver);
    });
};

const toggleTopic = (topicId) => {
    const index = expandedTopics.value.indexOf(topicId);
    if (index === -1) {
        expandedTopics.value.push(topicId);
    } else {
        expandedTopics.value.splice(index, 1);
    }
};

const scrollToSection = (letter) => {
    // Find the letter header element
    const letterElement = document.getElementById(`letter-${letter}`);
    
    if (letterElement) {
        // Use scrollIntoView with a block: "start" option to ensure the letter header is at the top of the viewport
        letterElement.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
        
        // This is an explicit user selection, not an auto-selection
        isAutoSelecting.value = false;
        
        // Explicitly emit the letter-scrolled event for immediate feedback
        emit('letter-scrolled', letter);
        
        // Expand all topics under this letter if they aren't already
        const topicsWithLetter = getTopicsByLetter(letter);
        topicsWithLetter.forEach(topic => {
            if (!expandedTopics.value.includes(topic.id)) {
                expandedTopics.value.push(topic.id);
            }
        });
    }
};

// Expose methods for parent component
defineExpose({
    scrollToSection
});
</script> 