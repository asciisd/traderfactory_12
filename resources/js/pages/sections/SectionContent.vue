<script setup lang="ts">
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import LessonItem from '@/pages/sections/partials/LessonItem.vue';
import { Section } from '@/types/courses';

interface Props {
    section: Section;
    canView: boolean | null;
}

defineProps<Props>();
</script>

<template>
    <dl v-if="section.lessons" class="w-full space-y-6">
        <Accordion type="single" class="w-full" collapsible>
            <AccordionItem v-for="(lesson, idx) in section.lessons" :key="idx" :value="lesson.name">
                <AccordionTrigger class="bg-primary p-4">{{ lesson.name }}</AccordionTrigger>
                <AccordionContent>
                    <div class="p-2 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <LessonItem v-for="(activity, activityIdx) in lesson.activities"
                                    :key="activityIdx"
                                    :activity="activity"
                                    :canView="canView"
                                    :course_price="section.course_price"
                                    :course_id="section.course_id"/>
                    </div>
                </AccordionContent>
            </AccordionItem>
        </Accordion>
    </dl>
</template>
