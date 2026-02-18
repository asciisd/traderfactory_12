<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { $trans } from '@/lib/translator';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Book, BookOpen, ExternalLink, Heart, Key, LayoutGrid, User } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: $trans('My Orders'),
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: $trans('My Profile'),
        href: '/profile',
        icon: User,
    },
    {
        title: 'تعديل كلمة السر',
        href: '/profile/password',
        icon: Key,
    },
    {
        title: 'المفضلة',
        href: '/favorites',
        icon: Heart,
    },
    {
        title: 'الدورات',
        href: '/courses',
        icon: BookOpen,
    },
    {
        title: 'الكتب',
        href: '/books',
        icon: Book,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Go To Home Page',
        href: '/',
        icon: ExternalLink,
    },
];
</script>

<template>
    <Sidebar :side="$page.props.locale === 'en' ? 'left' : 'right'" collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
