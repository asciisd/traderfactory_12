<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { egyCurrencyFormat, formattedDate } from '@/lib/currencyFormatter';
import { $trans } from '@/lib/translator';
import { type BreadcrumbItem } from '@/types';
import { Orders } from '@/types/orders';
import { Head } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';

interface Props {
    orders: Orders;
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
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 max-w-7xl mx-auto">
            <h1 class="text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl">
                {{ $trans('My Orders') }}
            </h1>
            <Card class="mt-4">
                <CardContent class="marker:text-product-pink list-inside">
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
                                <TableCell class="text-start"><Badge :class="order.status.bg_color">{{ egyCurrencyFormat(order.total) }}</Badge></TableCell>
                                <TableCell class="text-start">{{ formattedDate(order.created_at) }}</TableCell>
                                <TableCell class="text-start">
                                    <Button class="cursor-pointer" variant="default" v-if="order.is_downloadable" :href="order.download_url" @click="router.visit(order.download_url)">
                                        {{ $trans('Download') }}
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
