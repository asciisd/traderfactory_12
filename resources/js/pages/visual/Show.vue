<script setup>
import VideoModal from "@/components/modals/VideoModal.vue";
import VideoPlayer from "@/components/VideoPlayer.vue";
import '@videojs/themes/dist/fantasy/index.css';

defineProps({
    visual: Object
})

const play = () => {
    this.$refs.videoPlayer.player.play()
}
</script>

<template>
    <VideoModal>
        <VideoPlayer ref="videoPlayer" :options="visual.data.videoOptions" class="vjs-theme-fantasy"/>
    </VideoModal>
</template>
