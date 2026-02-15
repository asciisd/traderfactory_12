<template>
    <div :style="{backgroundImage: `url(${imageUrl})`}"
         class="bg-fixed bg-cover bg-no-repeat bg-blend-multiply w-full min-h-screen">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div
                class="pt-12 pb-16 px-4 sm:pt-16 sm:px-6 lg:px-8 lg:mx-auto w-full min-h-screen bg-background bg-opacity-75">
                <div class="text-base max-w-prose mx-auto lg:ms-auto lg:me-0 ">
                    <slot>
                        <!-- Content goes here -->
                    </slot>
                </div>
            </div>
            <div class="w-full h-full">
                <!-- Empty space for image -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        imageUrl: {
            type: String,
            default: ''
        }
    }
}
</script>
