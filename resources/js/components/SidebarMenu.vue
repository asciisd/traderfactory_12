<script setup lang="ts">
import { $trans } from '@/lib/translator';
import { LayoutDashboard, User, Heart, BookOpen, Book, Key } from 'lucide-vue-next';

const menuItems = [
  { text: 'لوحة التحكم', href: '/dashboard', icon: LayoutDashboard },
  { text: 'الملف الشخصي', href: '/profile', icon: User },
  { text: 'تعديل كلمة السر', href: '/profile/password', icon: Key },
  { text: 'المفضلة', href: '/favorites', icon: Heart },
  { text: 'الدورات', href: '/courses', icon: BookOpen },
  { text: 'الكتب', href: '/books', icon: Book },
];

const currentPath = window.location.pathname;

</script>

<template>
  <aside class="w-full md:w-64 bg-background min-h-screen p-7 flex flex-col border-l">
    <nav class="flex-1">
      <ul class="flex md:flex-col gap-2 md:gap-0 overflow-x-auto md:overflow-x-visible whitespace-nowrap">
        <li
          v-for="item in menuItems"
          :key="item.text"
          class="my-1"
        >
          <a
            :href="item.href"
            class="text-sm flex items-center gap-3 py-3 px-4 md:px-6 rounded-lg transition font-medium min-w-max md:min-w-0 text-lg"
            :class="[
              currentPath === item.href
                ? 'bg-product-orange text-foreground font-bold shadow'
                : 'text-foreground hover:text-product-orange',
            ]"
          >
            <component :is="item.icon" class="w-5 h-5" />
            <span>{{ $trans(item.text) }}</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>
</template>
