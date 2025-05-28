<script setup lang="ts">
import SectionLesson from "@/Pages/Section/Partials/SectionLesson.vue";
import ConfirmActionPopUp from "@/Components/ConfirmActionPopUp.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";

type Props = {
    section: object,
    canView: boolean
};

const props = defineProps<Props>()
const open = ref(false)
const form = useForm({
    course_id: props.section.course_id,
    price: props.section.course_price
})

const buyCourse = () => {
    form.post(route('orders.create', ['course', props.section.course_id]))
}
</script>

<template>
    <div>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto divide-y-2 divide-gray-200">
                <dl v-if="section.lessons" class="mt-6 space-y-6">
                    <template v-for="lesson in section.lessons" :key="lesson.id">
                        <SectionLesson :canView="canView" :lesson="lesson" @open="open = true"/>
                    </template>
                </dl>
            </div>
        </div>

        <ConfirmActionPopUp v-if="!$page.props.auth.user" :open="open" confirmText="تسجيل الدخول"
                            title="أنت غير مسجل لدينا برجاء تسجيل الدخول للأشتراك في الدورة" @close="open = false"
                            @confirm="buyCourse"/>
        <ConfirmActionPopUp v-if="$page.props.auth.user && !canView"
                            :confirmText="section.course_price <= 0 ? 'ابدأ الدورة' : 'شراء'" :open="open"
                            :title="section.course_price <= 0 ? 'برجاء الضغط على ابدأ الدورة لتتمكن من رؤية المحتوى' : 'برجاء شراء الدورة لتتمكن من رؤية المحتوى'"
                            @close="open = false" @confirm="buyCourse"/>
    </div>
</template>
