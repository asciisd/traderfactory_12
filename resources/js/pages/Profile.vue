<!-- filepath: resources/js/pages/Profile.vue -->
<script setup lang="ts">
import SidebarMenu from '@/components/SidebarMenu.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type User } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    user: User;
}>();

const form = useForm({
    first_name: props.user.first_name ?? '',
    last_name: props.user.last_name ?? '',
    phone: props.user.phone ?? '',
    email: props.user.email ?? '',
    profile_photo: null,
});

const preview = ref(props.user.profile_photo_url ?? '');

const fileInput = ref<HTMLInputElement | null>(null);

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];
    form.profile_photo = file ?? null;
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
}

function triggerFileInput() {
    fileInput.value?.click();
}

function updateProfile() {
    form.post(route('user.profile.update'), {
        forceFormData: true,
    });
}
</script>

<template>
    <Head title="حسابي" />
    <AppLayout>
        <div class="flex min-h-screen flex-col md:flex-row">
            <SidebarMenu />
            <main class="bg-background flex flex-1 items-start justify-center p-4">
                <!-- <p class="leading-8 tracking-tight">
              حسابي
            </p> -->
                <div class="bg-card flex w-full max-w-2xl flex-col items-center rounded-lg p-8 shadow">
                    <!-- صورة البروفايل في الأعلى -->
                    <div class="mb-8">
                        <div
                            class="border-primary-500 from-primary-100 to-primary-300 group relative flex h-36 w-36 cursor-pointer items-center justify-center overflow-hidden rounded-full border-4 bg-gradient-to-br shadow-xl transition-all duration-200 hover:shadow-2xl"
                            @click="triggerFileInput"
                            title="اضغط لتغيير الصورة"
                        >
                            <img
                                v-if="preview"
                                :src="preview"
                                class="h-full w-full object-cover transition-all duration-200 group-hover:scale-105"
                                alt="صورة البروفايل"
                            />
                            <span v-else class="text-primary-700 text-5xl font-bold select-none" style="letter-spacing: 2px">
                                {{ (form.first_name?.charAt(0) ?? '') + (form.last_name?.charAt(0) ?? '') }}
                            </span>
                            <!-- أيقونة كاميرا تظهر عند المرور -->
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 transition-opacity group-hover:opacity-100"
                            >
                                <div class="rounded-full bg-white/80 p-3 shadow-lg">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="text-background h-8 w-8"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm-6 6h12"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <input ref="fileInput" type="file" accept="image/*" @change="onFileChange" class="hidden" />
                        <div v-if="form.errors.profile_photo" class="mt-1 text-center text-xs text-red-500">{{ form.errors.profile_photo }}</div>
                    </div>
                    <!-- باقي الفورم -->
                    <form @submit.prevent="updateProfile" class="flex w-full flex-col items-start gap-8 md:flex-row" enctype="multipart/form-data">
                        <div class="grid w-full flex-1 grid-cols-6 gap-6 space-y-6">
                            <div class="col-span-3">
                                <label class="text-foreground mb-2 block text-sm font-medium">الاسم الأول</label>
                                <input
                                    v-model="form.first_name"
                                    type="text"
                                    class="focus:ring-primary-500 w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:outline-none"
                                />
                                <div v-if="form.errors.first_name" class="mt-1 text-xs text-red-500">{{ form.errors.first_name }}</div>
                            </div>
                            <div class="col-span-3">
                                <label class="text-foreground mb-2 block text-sm font-medium">الاسم الأخير</label>
                                <input
                                    v-model="form.last_name"
                                    type="text"
                                    class="focus:ring-primary-500 w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:outline-none"
                                />
                                <div v-if="form.errors.last_name" class="mt-1 text-xs text-red-500">{{ form.errors.last_name }}</div>
                            </div>
                            <div class="col-span-3">
                                <label class="text-foreground mb-2 block text-sm font-medium">رقم الهاتف</label>
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    class="focus:ring-primary-500 w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:outline-none"
                                />
                                <div v-if="form.errors.phone" class="mt-1 text-xs text-red-500">{{ form.errors.phone }}</div>
                            </div>
                            <div class="col-span-3">
                                <label class="text-foreground mb-2 block text-sm font-medium">البريد الإلكتروني</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="focus:ring-primary-500 w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:outline-none"
                                />
                                <div v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</div>
                            </div>
                            <div class="col-span-6 flex justify-end">
                                <button
                                    type="submit"
                                    class="bg-product-orange text-background rounded px-6 py-2 font-semibold transition"
                                    :disabled="form.processing"
                                >
                                    تحديث
                                </button>
                            </div>
                            <div v-if="$page.props.flash.success" class="col-span-6 mt-6 text-center font-medium text-green-600">
                                {{ $page.props.flash.success }}
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
