<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { egyCurrencyFormat, formattedDate } from '@/lib/currencyFormatter';
import { $trans } from '@/lib/translator';
import { type BreadcrumbItem } from '@/types';
import { Orders } from '@/types/orders';
import { Head, router } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import SidebarMenu from '@/components/SidebarMenu.vue';
import { LayoutDashboard, User, Heart, BookOpen, Book, Star } from 'lucide-vue-next';


interface Props {
    orders: Orders;
    courses_count: number;
    books_count: number;
    orders_count: number;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: $trans('Dashboard'),
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <SidebarMenu />
        <!-- Main Content -->
        <main class="flex-1 p-4 bg-background">
        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <div class="flex items-center gap-4 p-4 rounded-xl bg-card shadow">
                <div class="flex items-center justify-center w-12 h-12 rounded-full text-product-orange text-2xl">
                <BookOpen class="w-7 h-7" />
                </div>
                <div>
            <div class="text-2xl font-bold text-foreground">{{ courses_count }}</div>
                <div class="text-sm text-product-orange">دوراتك</div>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 rounded-xl bg-card shadow">
                <div class="flex items-center justify-center w-12 h-12 rounded-full text-product-orange text-2xl">
                <Book class="w-7 h-7" />
                </div>
                <div>
                <div class="text-2xl font-bold text-foreground">{{ books_count }}</div>
                <div class="text-sm text-product-orange">كتبك</div>
                </div>
            </div>
            <div class="flex items-center gap-4 p-4 rounded-xl bg-card shadow">
                <div class="flex items-center justify-center w-12 h-12 rounded-full text-product-orange text-2xl">
                <LayoutDashboard class="w-7 h-7" />
                </div>
                <div>
                <div class="text-2xl font-bold text-foreground">{{ orders_count }}</div>
                <div class="text-sm text-product-orange">طلباتك</div>
                </div>
            </div>
        </div>
          <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl max-w-7xl mx-auto">
            <p class="leading-8 tracking-tight">
              {{ $trans('My Orders') }}
            </p>
            <Card class="mt-1">
              <CardContent class="marker:text-product-pink list-inside overflow-x-auto">
                <Table>
                  <TableHeader>
                    <TableRow>
                      <TableHead class="text-start">{{ $trans('Name') }}</TableHead>
                      <TableHead class="text-start">{{ $trans('Type') }}</TableHead>
                      <TableHead class="text-start">{{ $trans('Price') }}</TableHead>
                      <TableHead class="text-start">{{ $trans('Date') }}</TableHead>
                      <TableHead class="text-start">{{ $trans('Actions') }}</TableHead>
                    </TableRow>
                  </TableHeader>
                  <TableBody>
                    <TableRow v-for="order in orders.data" :key="order.id">
                      <TableCell class="text-start font-medium">{{ order.order_title }}</TableCell>
                      <TableCell class="text-start">{{ $trans(order.order_type) }}</TableCell>
                      <TableCell class="text-start">
                        <Badge :class="order.status.bg_color">{{ egyCurrencyFormat(order.total) }}</Badge>
                      </TableCell>
                      <TableCell class="text-start">{{ formattedDate(order.created_at) }}</TableCell>
                      <TableCell class="text-start">
                        <Button
                          class="cursor-pointer"
                          variant="default"
                          v-if="order.is_downloadable"
                          :href="order.download_url"
                          @click="router.visit(order.download_url)"
                        >
                          {{ $trans('Download') }}
                        </Button>
                      </TableCell>
                    </TableRow>
                  </TableBody>
                </Table>
              </CardContent>
            </Card>
          </div>
        </main>
      </div>
    </AppLayout>
</template>
