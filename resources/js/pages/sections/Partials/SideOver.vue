<script setup lang="ts">
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import SideSectionCard from '@/Components/Cards/SideSectionCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

type Props = {
    slug: string;
};

defineProps<Props>();

const open = ref(false);
</script>
<template>
    <TransitionRoot :show="open" as="template">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <div class="fixed inset-0" />

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <TransitionChild
                            as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full"
                            enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0"
                            leave-to="translate-x-full"
                        >
                            <DialogPanel class="pointer-events-auto w-screen max-w-md">
                                <div class="bg-primary-100 flex h-full flex-col overflow-y-scroll py-6 shadow-xl">
                                    <div class="px-4 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <DialogTitle class="text-lg font-medium text-gray-900">قائمة الدورات </DialogTitle>
                                            <div class="flex h-7 items-center">
                                                <button
                                                    class="focus:ring-primary-500 rounded-md p-1 text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                                                    type="button"
                                                    @click="open = false"
                                                >
                                                    <span class="sr-only">Close panel</span>
                                                    <XMarkIcon aria-hidden="true" class="h-6 w-6" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative mt-6 flex-1 px-2 sm:px-6">
                                        <div class="mt-4 flex flex-col space-y-4 px-4 md:mt-8 md:space-y-8 md:px-8 lg:px-0">
                                            <SideSectionCard
                                                v-for="course in $page.props.courses.data"
                                                :key="course.slug"
                                                :section="course.sections[0]"
                                                :slug="slug"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <TransitionRoot
        :show="!open"
        enter="transition-opacity duration-700"
        enterFrom="opacity-0"
        enterTo="opacity-100"
        leave="transition-opacity duration-150"
        leaveFrom="opacity-100"
        leaveTo="opacity-0"
    >
        <div class="absolute top-6 right-6 z-20" @click="open = true">
            <PrimaryButton class="text-base">
                <Bars3Icon class="h-5 w-5 sm:ml-2" />
                <span class="max-sm:hidden"> قائمة الدورات </span>
            </PrimaryButton>
        </div>
    </TransitionRoot>
</template>
