<!-- filepath: resources/js/pages/Profile.vue -->
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SidebarMenu from '@/components/SidebarMenu.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { $trans } from '@/lib/translator';

const props = defineProps({ user: Object })

const form = useForm({
    first_name: props.user.data.first_name ?? '',
    last_name: props.user.data.last_name ?? '',
    phone: props.user.data.phone ?? '',
    email: props.user.data.email ?? '',
    profile_photo: null,
})

const preview = ref(props.user.data.profile_photo_path ?? props.user.data.profile_photo_url)

const fileInput = ref<HTMLInputElement | null>(null)

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0]
    form.profile_photo = file ?? null
    if (file) {
        const reader = new FileReader()
        reader.onload = e => { preview.value = e.target?.result as string }
        reader.readAsDataURL(file)
    }
}

function triggerFileInput() {
    fileInput.value?.click()
}

function updateProfile() {
    form.post(route('user.profile.update'), {
        forceFormData: true,
    })
}
</script>

<template>
    <Head title="حسابي" />
    <AppLayout>
      <div class="flex flex-col md:flex-row min-h-screen">
        <SidebarMenu />
        <main class="flex-1 p-4 bg-background flex justify-center items-start">
            <!-- <p class="leading-8 tracking-tight">
              حسابي
            </p> -->
          <div class="bg-card shadow rounded-lg p-8 w-full max-w-2xl flex flex-col items-center">
            <!-- صورة البروفايل في الأعلى -->
            <div class="mb-8">
              <div
                class="relative w-36 h-36 rounded-full overflow-hidden border-4 border-primary-500 shadow-xl bg-gradient-to-br from-primary-100 to-primary-300 flex items-center justify-center cursor-pointer group transition-all duration-200 hover:shadow-2xl"
                @click="triggerFileInput"
                title="اضغط لتغيير الصورة"
              >
                <img
                  v-if="preview"
                  :src="preview"
                  class="object-cover w-full h-full transition-all duration-200 group-hover:scale-105"
                  alt="صورة البروفايل"
                />
                <span
                  v-else
                  class="text-primary-700 text-5xl font-bold select-none"
                  style="letter-spacing:2px;"
                >
                  {{ (form.first_name?.charAt(0) ?? '') + (form.last_name?.charAt(0) ?? '') }}
                </span>
                <!-- أيقونة كاميرا تظهر عند المرور -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/20">
                  <div class="bg-white/80 rounded-full p-3 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-background" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm-6 6h12" />
                    </svg>
                  </div>
                </div>
              </div>
              <input
                ref="fileInput"
                type="file"
                accept="image/*"
                @change="onFileChange"
                class="hidden"
              />
              <div v-if="form.errors.profile_photo" class="text-red-500 text-xs mt-1 text-center">{{ form.errors.profile_photo }}</div>
            </div>
            <!-- باقي الفورم -->
            <form @submit.prevent="updateProfile" class="flex flex-col md:flex-row gap-8 items-start w-full" enctype="multipart/form-data">
              <div class="flex-1 w-full space-y-6 grid grid-cols-6 gap-6">
                <div class="col-span-3">
                  <label class="block mb-2 text-sm font-medium text-foreground">الاسم الأول</label>
                  <input v-model="form.first_name" type="text" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                  <div v-if="form.errors.first_name" class="text-red-500 text-xs mt-1">{{ form.errors.first_name }}</div>
                </div>
                <div class="col-span-3">
                  <label class="block mb-2 text-sm font-medium text-foreground">الاسم الأخير</label>
                  <input v-model="form.last_name" type="text" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                  <div v-if="form.errors.last_name" class="text-red-500 text-xs mt-1">{{ form.errors.last_name }}</div>
                </div>
                <div class="col-span-3">
                  <label class="block mb-2 text-sm font-medium text-foreground">رقم الهاتف</label>
                  <input v-model="form.phone" type="text" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                  <div v-if="form.errors.phone" class="text-red-500 text-xs mt-1">{{ form.errors.phone }}</div>
                </div>
                <div class="col-span-3">
                  <label class="block mb-2 text-sm font-medium text-foreground">البريد الإلكتروني</label>
                  <input v-model="form.email" type="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                  <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                </div>
                <div class="col-span-6 flex justify-end flex justify-end">
                  <button type="submit" class="bg-product-orange text-background font-semibold px-6 py-2 rounded transition" :disabled="form.processing">
                    تحديث
                  </button>
                </div>
                <div v-if="$page.props.flash.success" class="col-span-6 mt-6 text-green-600 text-center font-medium">
                  {{ $page.props.flash.success }}
                </div>
              </div>
            </form>
          </div>
        </main>
      </div>
    </AppLayout>
</template>
