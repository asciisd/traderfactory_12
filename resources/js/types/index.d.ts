import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    canLogin: boolean;
    canRegister: boolean;
    laravelVersion: string;
    phpVersion: string;
    progress: number;
    settings: Settings;
    locale: string;
    currency: string;
    language: string;
    courses: string;
    flash: Flash;
}

export interface Settings {
    site_title: string;
    site_subtitle: string;
    site_description: string;
    start_learning: string;
    header_s3: string;
}

export interface Flash {
    success: string;
    failed: string;
}

export interface User {
    id: number;
    first_name: string;
    last_name: string;
    phone: string
    email: string;
    profile_photo_url?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Metadata {
    title: string;
    keywords: string;
    description: string;
    image: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
