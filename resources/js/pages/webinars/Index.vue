<template>
    <GuestLayout title="Webinars">
        <template #header>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold mb-8">
                    الندوات
                </h1>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <main>
                    <div class="max-w-7xl">
                        <FullCalendar ref="fullCalendar" :options="calendarOptions"
                                      class="h-screen p-8 rounded-lg"/>
                        <Modal :closeable="true" :show="show" max-width="2xl" @close="close">
                            <Webinar v-if="show" :current-event="currentEvent"/>
                        </Modal>
                    </div>
                </main>

            </div>
        </div>
    </GuestLayout>
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import interactionPlugin from "@fullcalendar/interaction";
import Webinar from "./Webinar.vue";
import GuestLayout from "@/layouts/GuestLayout.vue";
import Modal from '@/components/Modal.vue'

export default {
    components: {FullCalendar, Webinar, GuestLayout, Modal},
    data() {
        return {
            // webinars: [],
            show: false,
            showModal: false,
            currentEvent: {},
            calendarOptions: {
                events: '/events',
                initialView: "dayGridMonth",
                eventClick: this.handleEventClick,
                selectable: true,
                locale: 'ar',
                nowIndicator: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                },
                timeFormat: 'HH:mm:ss',
                plugins: [
                    dayGridPlugin,
                    interactionPlugin,
                    timeGridPlugin,
                    listPlugin,
                ],
            },
        };
    },
    methods: {
        handleEventClick(event) {
            this.currentEvent = event;
            this.show = true;
        },
        close() {
            this.show = false;
        },
    },
};
</script>

<style scoped>

</style>
