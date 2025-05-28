<script setup lang="ts">
import {Link, useForm} from '@inertiajs/vue3';
import RadialProgress from "vue3-radial-progress";
import VideoModal from "@/Components/Modals/VideoModal.vue";
import VideoPlayer from "@/Components/VideoPlayer.vue";
import '@videojs/themes/dist/fantasy/index.css';

type Props = {
    activity: any,
    canView: boolean
};

type Emits = {
    (e: 'open'): void
};

defineProps<Props>();
defineEmits<Emits>();

const showVideo = ref(false);
const userProgress = ref(0);

const videoClosed = () => {
    showVideo.value = false;
    userProgress.value = $refs.videoPlayer.player.currentTime() / $refs.videoPlayer.player.duration() * 100;
    console.log('video closed on : ' + userProgress.value);
    updateVisualProgress();
}

const updateVisualProgress = () => {
    if (activity.item.user_progress < 100 && activity.item.user_progress < userProgress.value) {
        useForm({
            user_progress: userProgress.value.toFixed(2),
        }).put(route('visuals.progress', activity.item), {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <div v-if="activity.item"
         class="group relative cursor-pointer rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 rtl:space-x-reverse hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary-500">

        <div class="flex-shrink-0">
            <RadialProgress :diameter="70" :completed-steps="activity.item.user_progress" :total-steps="100"
                            :stroke-width="4" :inner-stroke-width="4" inner-stroke-color="rgb(209 213 219)"
                            start-color="#017ea1" stop-color="#017ea1">
                <component :is="activity.icon"
                           class="h-6 w-6 text-primary stroke-current transform group-hover:rotate-[-8deg] transition"/>
            </RadialProgress>

        </div>
        <div v-if="!canView" class="flex-1 min-w-0">
            <div :key="activity?.item.id" class="focus:outline-none">
                <span aria-hidden="true" class="absolute inset-0 a" @click="$emit('open')"/>
                <div class="flex justify-between">
                    <p class="text-sm font-medium text-gray-900">
                        {{ activity.title }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ activity.item.duration }}
                    </p>
                </div>
            </div>
        </div>

        <div v-if="canView" class="flex-1 min-w-0">
            <a v-if="activity.icon === 'VideoCameraIcon'" :key="activity.item.id" class="focus:outline-none" href="#"
               @click.prevent="showVideo = true">
                <span aria-hidden="true" class="absolute inset-0"/>

                <div class="flex justify-between">
                    <p class="text-sm font-medium text-gray-900">
                        {{ activity.title }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ activity.item.duration }}
                    </p>
                </div>
            </a>
            <Link v-else :key="activity?.item.id" :href="activity.href" class="focus:outline-none">
                <span aria-hidden="true" class="absolute inset-0"/>
                <div class="flex justify-between">
                    <p class="text-sm font-medium text-gray-900">
                        {{ activity.title }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ activity.item.duration }}
                    </p>
                </div>
            </Link>
        </div>

        <video-modal v-if="activity.icon === 'VideoCameraIcon'" :show="showVideo" @close="videoClosed">
            <video-player ref="videoPlayer" :options="activity.item.videoOptions" class="vjs-theme-fantasy"/>
        </video-modal>
    </div>
</template>
