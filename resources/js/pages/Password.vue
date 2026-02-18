<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SidebarMenu from '@/components/SidebarMenu.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});
function updatePassword() {
  form.post(route('user.password.update'), { forceFormData: true });
}
</script>

<template>
  <Head title="تغيير كلمة المرور" />
  <AppLayout>
    <div class="flex flex-col md:flex-row min-h-screen">
      <SidebarMenu />
      <main class="flex-1 p-4 bg-background flex justify-center items-start">
        <div class="bg-card shadow rounded-lg p-8 w-full max-w-2xl flex flex-col items-center">
          <!-- <h2 class="text-2xl font-bold mb-8 text-center">تغيير كلمة المرور</h2> -->
          <form @submit.prevent="updatePassword" class="w-full" enctype="multipart/form-data">
            <div class="grid grid-cols-6 gap-6">
              <div class="col-span-6">
                <label class="block mb-2 text-sm font-medium text-foreground">كلمة المرور الحالية</label>
                <input v-model="form.current_password" type="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                <div v-if="form.errors.current_password" class="text-red-500 text-xs mt-1">{{ form.errors.current_password }}</div>
              </div>
              <div class="col-span-3">
                <label class="block mb-2 text-sm font-medium text-foreground">كلمة المرور الجديدة</label>
                <input v-model="form.password" type="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
              </div>
              <div class="col-span-3">
                <label class="block mb-2 text-sm font-medium text-foreground">تأكيد كلمة المرور الجديدة</label>
                <input v-model="form.password_confirmation" type="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" />
                <div v-if="form.errors.password_confirmation" class="text-red-500 text-xs mt-1">{{ form.errors.password_confirmation }}</div>
              </div>
              <div class="col-span-6 flex justify-end">
                <button type="submit" class="bg-product-orange text-background font-semibold px-6 py-2 rounded transition" :disabled="form.processing">
                  تغيير كلمة المرور
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
