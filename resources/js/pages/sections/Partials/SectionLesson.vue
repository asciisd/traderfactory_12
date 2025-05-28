<script setup lang="ts">
import {ChevronDownIcon} from "@heroicons/vue/24/outline";
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import LessonGroup from "./LessonGroup.vue";

type Props = {
    lesson: any
    canView: boolean
};

type Emits = {
    (e: 'open'): void
};

defineProps<Props>();
defineEmits<Emits>();

</script>

<template>
    <Disclosure v-if="lesson" :ref="`lesson-${lesson.id}`" v-slot="{ open }"
                :default-open="true" as="div" class="pt-6">
        <dt class="text-lg">
            <DisclosureButton class="text-start p-4 w-full flex justify-between items-start text-white bg-primary">
                <span class="font-medium text-white">
                  {{ lesson.name }}
                </span>
                <span class="ms-6 h-7 flex items-center">
                    <ChevronDownIcon :class="[open ? '-rotate-180' : 'rotate-0', 'h-6 w-6 transform']"
                                     aria-hidden="true"/>
                </span>
            </DisclosureButton>
        </dt>
        <!-- Use the built-in <transition> component to add transitions. -->
        <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-out"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0">

            <DisclosurePanel as="dd" class="mt-2">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <lesson-group :canView="canView" :lesson="lesson" @open="$emit('open')"/>
                </div>
            </DisclosurePanel>
        </transition>
    </Disclosure>
</template>
