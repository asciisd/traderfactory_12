<template>
    <QuickScanLayout :image-url="quickScanBegin ? '' : quickScan.s3_image">
        <div v-if="quickScanBegin">
            <!--  Questions  -->
            <div v-if="!showResults">
                <AnswersList :key="idx" :old-answer="currentAnswer" :question="questions[idx]"
                             @questionAnswer="answered"/>

                <TransitionRoot :show="canFinishQuickScan" appear as="template"
                                enter="transform transition duration-[800ms] ease-out"
                                enter-from="translate-x-12 opacity-0"
                                enter-to="translate-x-0 opacity-100">

                    <button
                        class="mt-12 col-span-2 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-secondary-600 text-base font-medium text-white hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 sm:text-sm"
                        type="button"
                        @click="showResults = true">
                        انهاء الاختبار
                    </button>
                </TransitionRoot>
                <MagazinePagination :currentPage="currentPage" :pages="totalPages" @pageChanged="pageChanged"/>
            </div>

            <!--  Results  -->
            <div v-else class="p-12 bg-white rounded-lg shadow-lg w-full mt-8">
                <div>
                    <QuickScanResult :answers="answers" :questions="questions" :total-answers="totalPages"
                                     @resetQuickScan="resetQuickScan"/>
                </div>
            </div>
        </div>
        <div v-else>

            <!--  Start Page  -->
            <TransitionRoot
                :show="true"
                appear
                as="template"
                enter="transform transition duration-[1500ms]"
                enter-from="opacity-0 rotate-[-120deg] scale-50"
                enter-to="opacity-100 rotate-0 scale-100"
                leave="transform duration-200 transition ease-in-out"
                leave-from="opacity-100 rotate-0 scale-100 "
                leave-to="opacity-0 scale-95 ">
                <StartQuickScan :quick-scan="quickScan" @startQuickScan="quickScanBegin = true"/>
            </TransitionRoot>
        </div>
    </QuickScanLayout>
</template>

<script>
import QuickScanLayout from "./QuickScanLayout.vue";
import StartQuickScan from "./StartQuickScan.vue";
import {TransitionRoot} from "@headlessui/vue";
import QuickScanItem from "./QuickScanItem.vue";
import QuickScanResult from "./QuickScanResult.vue";
import AnswersList from "./AnswersList.vue";
import MagazinePagination from "@/components/pagination/MagazinePagination.vue";
import {useForm} from "@inertiajs/vue3";

export default {
    props: ['quickScan'],

    components: {
        MagazinePagination,
        AnswersList, QuickScanResult, QuickScanItem, QuickScanLayout, StartQuickScan, TransitionRoot
    },
    data() {
        return {
            idx: 0,
            answers: ['', '', ''],
            currentPage: 1,
            wrongAnswers: 0,
            correctAnswers: 0,
            showResults: false,
            quickScanBegin: false,
            canFinishQuickScan: false,
            questions: this.quickScan.data.quick_questions,
            userProgress: 0.0
        }
    },
    computed: {
        totalPages() {
            return this.questions.length;
        },
        currentAnswer() {
            return this.answers[this.idx];
        },
        progress() {
            return (this.currentPage / this.totalPages * 100);
        }
    },
    methods: {
        answered(choice) {
            this.incrementUserProgress();
            this.saveAnswer(this.idx, choice);
            if (this.allQuestionsAnswered()) {
                this.canFinishQuickScan = true
            }
        },
        saveAnswer(index, choice) {
            this.answers.splice(index, 1, choice)
        },
        allQuestionsAnswered() {
            let noEmptyResult = true;
            for (let i = 0; i < this.answers.length; i++) {
                if (this.answers[i] === '') {
                    noEmptyResult = false
                }
            }

            return this.answers.length === this.questions.length && noEmptyResult
        },
        pageChanged(page) {
            this.currentPage = page;
            this.idx = page - 1;
        },
        incrementUserProgress() {
            if (this.userProgress <= this.progress) {
                this.userProgress = this.progress;
            }
        },
        resetQuickScan() {
            this.idx = 0
            this.answers = []
            this.currentPage = 1
            this.wrongAnswers = 0
            this.correctAnswers = 0
            this.showResults = false
            this.quickScanBegin = false
            this.canFinishQuickScan = false
        }
    },
    beforeUnmount() {
        if (this.quickScan.user_progress < 100) {
            useForm({
                user_progress: this.userProgress.toFixed(2),
            }).put(route('quickScans.progress', this.quickScan), {
                preserveScroll: true,
            })
        }
    }
}
</script>
