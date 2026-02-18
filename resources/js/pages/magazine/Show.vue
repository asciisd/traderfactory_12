<template>
    <div>
        <slide :slide="magazine.data.slides[pageIndex]"/>
        <magazine-pagination :currentPage="currentPage" :pages="totalPages" @pageChanged="pageChanged"/>
    </div>
</template>

<script>
import {defineComponent} from "vue";
import MagazinePagination from "@/components/pagination/MagazinePagination.vue";
import Slide from "./partials/Slide.vue";
import {useForm} from "@inertiajs/vue3";
import LessonLayout from "@/layouts/LessonLayout.vue";

export default defineComponent({
    layout: LessonLayout,
    props: {
        magazine: {
            type: Object,
            default: {},
            required: true
        }
    },
    data() {
        return {
            currentPage: 1,
            userProgress: 0.0
        }
    },
    components: {
        Slide,
        MagazinePagination
    },
    computed: {
        totalPages() {
            return this.magazine.data.slides.length;
        },
        pageIndex() {
            return this.currentPage - 1;
        },
        progress() {
            return (this.currentPage / this.totalPages * 100);
        }
    },
    methods: {
        pageChanged(page) {
            this.currentPage = page;
            this.incrementUserProgress();
        },
        incrementUserProgress() {
            if (this.userProgress <= this.progress) {
                this.userProgress = this.progress;
            }
        },
    },
    mounted() {
        this.incrementUserProgress();
    },
    beforeUnmount() {
        if (this.magazine.user_progress < 100) {
            useForm({user_progress: this.userProgress.toFixed(2),})
                .put(route('magazines.progress', this.magazine), {
                    preserveScroll: true,
                })
        }
    }
})
</script>
