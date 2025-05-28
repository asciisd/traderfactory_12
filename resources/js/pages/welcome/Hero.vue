<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Settings } from '@/types';
import { Link } from '@inertiajs/vue3';

interface Props {
    settings: Settings;
}

defineProps<Props>();
</script>

<template>
    <div class="min-h-[80vh] bg-cover bg-bottom lg:relative">
        <div class="flex flex-col lg:flex-row mx-auto w-full max-w-7xl pt-16 pb-20 text-center lg:py-48 lg:text-start">
            <div class="px-4 sm:px-8 lg:w-2/3 xl:pe-16">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                    <span class="text-primary block leading-loose xl:inline" v-html="settings.site_title" />
                    <span class="block leading-relaxed font-medium" v-html="settings.site_subtitle" />
                </h1>
                <p class="text-md mt-2 font-normal tracking-tight xl:text-xl" v-html="settings.site_description" />
                <div class="mt-10 sm:flex sm:justify-center lg:justify-start">
                    <Button class="mt-4 w-64" size="lg">
                        <Link :href="route('courses.index')">تصفح الدورات</Link>
                    </Button>
                </div>
            </div>
            <img
                alt=""
                class="relative mx-auto max-h-96 mt-16 lg:mt-0"
                src="/img/undraw_online-learning_tgmv.svg"
                width="490"
            />
        </div>
        <div class="relative h-64 w-full sm:h-72 md:h-96 lg:absolute lg:inset-y-0 lg:end-0 lg:h-full lg:w-1/2"></div>
    </div>
</template>
