<script setup lang="ts">
import LessonItem from "./LessonItem.vue";

type Props = {
    lesson: any;
    canView: boolean;
};

type Emits = {
    (e: 'open'): void;
};

defineProps<Props>();
defineEmits<Emits>();
</script>

<template>
    <template v-for="(activity, index) in lesson.activities" :key="index">
        <LessonItem :activity="activity" :canView="canView" @open="$emit('open')"/>
    </template>
</template>
