<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <TransitionRoot :show="open" as="template">
        <Dialog as="div" class="fixed z-20 inset-0 overflow-y-auto" @close="open = false">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300"
                                 enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                 leave-from="opacity-100 translate-y-0 sm:scale-100"
                                 leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-start overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full sm:p-6">
                        <ConfettiExplosion :colors="['#82055f','#003969','#a1c814','#eb6600','#c8b987','#5ac9f5']"
                                           :particleCount="100"/>
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">

                            <div class="flex flex-col justify-between">
                                <div class="flex items-center justify-center mt-3 text-center">
                                    <ve-progress :progress="progress?.model.user_progress" :size="80"
                                                 :thickness="4" color="#003a69">
                                        <div class="w-full h-full rounded-full bg-primary">
                                            <component :is="progress?.model.icon"
                                                       class="p-3 h-16 w-16 text-white stroke-current transform group-hover:rotate-[-8deg] transition"/>
                                        </div>
                                    </ve-progress>
                                </div>
                                <div class="bg-gray-100 p-8 rounded-md mt-5 sm:mt-0">
                                    <p class="text-sm text-center text-gray-500">
                                        ممتاز، لقد قمت باكمال هذا المحتوى
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="bg-gray-100 p-8 rounded-md mt-5 sm:mt-0">
                                    <p class="text-sm text-center text-gray-500">
                                        تقييمك يساعدنا على التحسين من دوراتنا، كيف تُقيّم تجربتك معنا؟
                                    </p>
                                    <star-rating v-model:rating="rating" :animate="true"
                                                 :rounded-corners="true" :rtl="true" :show-rating="false"
                                                 :star-size="30" class="justify-center mt-4"/>
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button
                                        class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm"
                                        type="button"
                                        @click="open = false">
                                        سوف يتم اغلاق الصفحة تلقائيا بعد
                                        {{ this.remainingTime }}
                                        ثواني
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {ref} from 'vue'
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {
    AcademicCapIcon,
    BookOpenIcon,
    ChevronDownIcon,
    ClipboardDocumentListIcon,
    ForwardIcon,
    MagnifyingGlassIcon,
    QuestionMarkCircleIcon,
    VideoCameraIcon
} from '@heroicons/vue/24/outline'
import StarRating from 'vue-star-rating'
import {VeProgress} from "vue-ellipse-progress";
import ConfettiExplosion from "vue-confetti-explosion";
import ProgressButton from "@/Components/Buttons/ProgressButton.vue";
import {useForm} from "@inertiajs/vue3";

export default {
    components: {
        ConfettiExplosion,
        ProgressButton,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        StarRating,
        VeProgress,
        BookOpenIcon,
        ClipboardDocumentListIcon,
        ForwardIcon,
        QuestionMarkCircleIcon,
        MagnifyingGlassIcon,
        AcademicCapIcon,
        ChevronDownIcon,
        VideoCameraIcon,
    },
    props: ['progress'],
    data() {
        return {
            remainingTime: 10
        }
    },
    mounted() {
        this.startCounter();
    },
    watch: {
        open: function (newVal, oldVal) {
            if (!newVal) {
                useForm({
                    rate: this.rating
                }).put(this.progress.href, {
                    preserveScroll: true,
                });
            }
        }
    },
    methods: {
        startCounter() {
            let self = this;

            let interval = setInterval(function () {
                self.remainingTime = a.getTimeLeft();
            }, 1000);

            let a = new timer(function () {
                self.open = false;
                console.log("bye bye!");
                clearInterval(interval);
                self.remainingTime = 10
            }, 11 * 1000);
        },
    },
    setup() {
        const open = ref(true);
        const rating = ref(0);

        return {
            open,
            rating,
        }
    },


}

class timer {
    id = null;
    remaining = 0;
    callback = null;
    started = null;
    running = false;

    constructor(__callback, __delay) {
        this.remaining = __delay
        this.callback = __callback

        this.start()
    }

    start() {
        this.running = true
        this.started = new Date()
        this.id = setTimeout(this.callback, this.remaining)
    }

    pause() {
        this.running = false
        clearTimeout(this.id)
        this.remaining -= new Date() - this.started
    }

    getTimeLeft() {
        if (this.running) {
            this.pause()
            this.start()
        }

        return Math.ceil(this.remaining / 1000);
    }

    getStateRunning() {
        return this.running
    }
}
</script>
