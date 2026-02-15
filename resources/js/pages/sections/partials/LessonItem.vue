<script setup lang="ts">
import { Activity } from '@/types/courses';
import { router, usePage } from '@inertiajs/vue3';
import RadialProgress from 'vue3-radial-progress';
import { useForm } from '@inertiajs/vue3';
import { GraduationCapIcon, FilmIcon, NewspaperIcon, FlaskRoundIcon, FastForwardIcon, ClipboardListIcon, SearchCodeIcon } from 'lucide-vue-next';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { ref } from 'vue';

const page = usePage();
const icons = {
    Goal: GraduationCapIcon,
    Magazine: NewspaperIcon,
    Revision: FastForwardIcon,
    Todo: ClipboardListIcon,
    QuickScan: SearchCodeIcon,
    Quiz: FlaskRoundIcon,
    Visual: FilmIcon,
};

interface Props {
    activity: Activity;
    canView: boolean | null;
    course_id: number;
    course_price: number;
}

const props = defineProps<Props>();

const needLogin = ref(false);

const visitActivity = () => {
    if (!props.canView) {
        return needLogin.value = true;
    }

    router.visit(props.activity.href);
};

const form = useForm({
    course_id: props.course_id,
    price: props.course_price,
});

const buyCourse = () => {
    form.post(route('orders.create', ['course', props.course_id]), {
        preserveScroll: true,
        onSuccess: () => needLogin.value = false,
    });
};
</script>

<template>
    <div
        class="group focus-within:ring-primary relative flex cursor-pointer items-center space-x-3 rounded-lg border border-gray-300 px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-offset-2 hover:border-gray-400"
    >
        <div class="flex-shrink-0">
            <RadialProgress
                :diameter="70"
                :completed-steps="activity.item.user_progress"
                :total-steps="100"
                :stroke-width="4"
                :inner-stroke-width="4"
                inner-stroke-color="#f9981030"
                start-color="#017ea1"
                stop-color="#017ea1"
            >
                <Component :is="icons[activity.model]" class="text-primary h-8 w-8 transform stroke-current transition group-hover:rotate-[-12deg]" />
            </RadialProgress>
        </div>

        <div class="min-w-0 flex-1">
            <div @click.prevent="visitActivity" class="focus:outline-none">
                <span aria-hidden="true" class="absolute inset-0" />
                <div class="flex justify-between">
                    <p class="text-sm font-medium text-foreground-900">
                        {{ activity.title }}
                    </p>
                    <p class="truncate text-sm text-foreground-500">
                        {{ activity.item.duration }} دقيقة
                    </p>
                </div>
            </div>
        </div>
    </div>

    <AlertDialog :open="needLogin">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>تسجيل الدخول</AlertDialogTitle>
                <AlertDialogDescription> أنت غير مسجل لدينا برجاء تسجيل الدخول للأشتراك في الدورة </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="needLogin = false">الغاء</AlertDialogCancel>
                <AlertDialogAction v-if="!page.props.auth?.user" @click="router.visit(route('login'))">تسجيل الدخول</AlertDialogAction>
                <AlertDialogAction v-if="page.props.auth?.user" @click="buyCourse">{{ course_price <= 0 ? 'ابدأ الدورة' : 'شراء' }}</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
