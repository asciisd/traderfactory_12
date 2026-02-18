<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { egyCurrencyFormat, formattedDate } from '@/lib/currencyFormatter';
import { $trans } from '@/lib/translator';
import { type BreadcrumbItem } from '@/types';
import { Orders } from '@/types/orders';
import { Head, router } from '@inertiajs/vue3';
import { Book, BookOpen, LayoutDashboard } from 'lucide-vue-next';

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
        <div class="mx-auto max-w-7xl p-4">
            <div class="mt-3 mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                <div class="bg-card flex items-center gap-4 rounded-xl p-4 shadow">
                    <div class="text-product-orange flex h-12 w-12 items-center justify-center rounded-full text-2xl">
                        <BookOpen class="h-7 w-7" />
                    </div>
                    <div>
                        <div class="text-foreground text-2xl font-bold">{{ courses_count }}</div>
                        <div class="text-product-orange text-sm">دوراتك</div>
                    </div>
                </div>
                <div class="bg-card flex items-center gap-4 rounded-xl p-4 shadow">
                    <div class="text-product-orange flex h-12 w-12 items-center justify-center rounded-full text-2xl">
                        <Book class="h-7 w-7" />
                    </div>
                    <div>
                        <div class="text-foreground text-2xl font-bold">{{ books_count }}</div>
                        <div class="text-product-orange text-sm">كتبك</div>
                    </div>
                </div>
                <div class="bg-card flex items-center gap-4 rounded-xl p-4 shadow">
                    <div class="text-product-orange flex h-12 w-12 items-center justify-center rounded-full text-2xl">
                        <LayoutDashboard class="h-7 w-7" />
                    </div>
                    <div>
                        <div class="text-foreground text-2xl font-bold">{{ orders_count }}</div>
                        <div class="text-product-orange text-sm">طلباتك</div>
                    </div>
                </div>
            </div>
            <div class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl">
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
        </div>
    </AppLayout>
</template>
