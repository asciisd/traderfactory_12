<template>
    <nav class="fixed inset-x-0 bottom-0 mb-2 h-8 w-full z-10 flex justify-center space-x-2 rtl:space-x-reverse">
        <a :class="[currentPage >= pages ? 'cursor-not-allowed text-gray-100' : 'text-gray-500' ]"
           class="relative inline-flex items-center rounded-md border border-gray-300 bg-white text-sm font-medium hover:bg-gray-50"
           href="#"
           @click.prevent="getNextPage">
            <span class="sr-only">Next</span>
            <ChevronRightIcon aria-hidden="true" class="h-8 w-8"/>
        </a>
        <div aria-current="page"
             class="z-10 rounded-md bg-white text-gray-600 relative inline-flex items-center px-4 py-2 border text-lg font-semibold">
            {{ currentPage }}/{{ pages }}
        </div>
        <a :class="[currentPage === 1 ? 'cursor-not-allowed text-gray-100' : 'text-gray-500']"
           class="relative inline-flex items-center rounded-md border border-gray-300 bg-white text-sm font-medium hover:bg-gray-50"
           href="#"
           @click.prevent="getPreviousPage">
            <span class="sr-only">Previous</span>
            <ChevronLeftIcon aria-hidden="true" class="h-8 w-8"/>
        </a>
    </nav>
</template>

<script>
import {defineComponent} from "vue";
import {ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/24/solid'

export default defineComponent({
    emits: ["pageChanged"],
    props: {
        pages: {
            type: Number,
            default: 0
        },
        currentPage: {
            type: Number,
            default: 1
        }
    },
    components: {
        ChevronLeftIcon,
        ChevronRightIcon
    },
    methods: {
        getPage(page) {
            this.$emit('pageChanged', page);
        },
        getPreviousPage() {
            if (this.currentPage === 1) return;
            this.getPage(this.currentPage - 1)
        },
        getNextPage() {
            if (this.currentPage >= this.pages) return;
            this.getPage(this.currentPage + 1)
        }
    },
    mounted() {
        let self = this;

        // get more info from https://www.freecodecamp.org/news/javascript-keycode-list-keypress-event-key-codes/
        window.addEventListener('keyup', function (ev) {

            if (ev.key === 'ArrowLeft') {
                self.getPreviousPage();
            }

            if (ev.key === 'ArrowRight') {
                self.getNextPage();
            }
        });
    }
})
</script>

<style scoped>

</style>
