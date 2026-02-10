<script setup>
import {ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3'
import ApplicationMark from '@/components/ApplicationMark.vue';
import Banner from '@/components/Banner.vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import NavLink from '@/components/NavLink.vue';
import ResponsiveNavLink from '@/components/ResponsiveNavLink.vue';
import SecondaryLinkButton from "@/components/buttons/SecondaryLinkButton.vue";
import PrimaryLinkButton from "@/components/buttons/PrimaryLinkButton.vue";
import FooterSocialLinksOnly from "@/components/footers/FooterSocialLinksOnly.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="$page.props.metadata?.title ?? title">
            <meta v-if="$page.props.metadata?.keywords" :content="$page.props.metadata?.keywords" name="keywords">

            <meta v-if="$page.props.metadata?.description" :content="$page.props.metadata?.description"
                  name="description">
            <meta v-if="$page.props.metadata?.description" :content="$page.props.metadata?.description"
                  name="twitter:description">
            <meta v-if="$page.props.metadata?.description" :content="$page.props.metadata?.description"
                  property="og:description">

            <meta v-if="$page.props.metadata?.image" :content="$page.props.metadata?.image" name="image">
            <meta v-if="$page.props.metadata?.image" :content="$page.props.metadata?.image" name="twitter:image">
            <meta v-if="$page.props.metadata?.image" :content="$page.props.metadata?.image" property="og:image">
        </Head>

        <Banner/>

        <div class="min-h-screen bg-white">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('welcome')">
                                    <ApplicationMark class="block w-28"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 rtl:space-x-reverse sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :active="route().current('welcome')" :href="route('welcome')">
                                    الرئيسية
                                </NavLink>
                                <NavLink :active="route().current('courses.index')" :href="route('courses.index')">
                                    الدورات
                                </NavLink>
                                <NavLink :active="route().current('books')" :href="route('books.index')">
                                    الكتب
                                </NavLink>
                                <NavLink :active="route().current('tools.*')" :href="route('tools.index')">
                                    الأدوات
                                </NavLink>
                                <!-- <NavLink :active="route().current('glossary.*')" :href="route('glossary.index')">
                                    مصطلحات الفوركس
                                </NavLink> -->
                                <NavLink :active="route().current('faqs')" :href="route('faqs.index')">
                                    الأسئلة الشائعة
                                </NavLink>
                                <NavLink :active="route().current('about')" :href="route('about')">
                                    من نحن
                                </NavLink>
                            </div>
                        </div>

                        <div v-if="$page.props.auth.user" class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream &&$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition"
                                                type="button">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" fill="currentColor"
                                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path clip-rule="evenodd"
                                                          d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                          fill-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream && $page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    ادارة الفريق
                                                </div>

                                                <!-- Team Settings -->
                                                <DropdownLink
                                                    :href="route('teams.show', $page.props.auth.user.current_team)">
                                                    اعدادات الفريق
                                                </DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream && $page.props.jetstream.canCreateTeams"
                                                              :href="route('teams.create')">
                                                    انشاء فريق جديد
                                                </DropdownLink>

                                                <div class="border-t border-gray-100"/>

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    تغيير الفريق
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams"
                                                          :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg
                                                                    v-if="team.id == $page.props.auth.user.current_team_id"
                                                                    class="me-2 h-5 w-5 text-green-400" fill="none"
                                                                    stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream && $page.props.jetstream.managesProfilePhotos"
                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img :alt="$page.props.auth.user.name"
                                                 :src="$page.props.auth.user.profile_photo_url"
                                                 class="h-8 w-8 rounded-full object-cover">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition"
                                                type="button">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" fill="currentColor"
                                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path clip-rule="evenodd"
                                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                          fill-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('dashboard')">
                                            اللوحة الرئيسية
                                        </DropdownLink>

                                        <!-- <DropdownLink :href="route('profile.show')">
                                            حسابي
                                        </DropdownLink> -->

                                        <DropdownLink v-if="$page.props.jetstream && $page.props.jetstream.hasApiFeatures"
                                                      :href="route('api-tokens.index')">
                                            توكن
                                        </DropdownLink>

                                        <div class="border-t border-gray-100"/>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                تسجيل الخروج
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div v-else class="hidden sm:flex sm:items-center sm:ms-6">
                            <SecondaryLinkButton v-if="$page.props.canRegister" :href="route('login')">
                                تسجيل الدخول
                            </SecondaryLinkButton>
                            <PrimaryLinkButton v-if="$page.props.canRegister" :href="route('register')" class="ms-8">
                                مستخدم جديد
                            </PrimaryLinkButton>
                        </div>
                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"/>
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :active="route().current('welcome')" :href="route('welcome')">
                            الرئيسية
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :active="route().current('courses.index')" :href="route('courses.index')">
                            الدورات
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :active="route().current('books')" :href="route('books.index')">
                            الكتب
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :active="route().current('tools.*')" :href="route('tools.index')">
                            الأدوات
                        </ResponsiveNavLink>
                        <!-- <ResponsiveNavLink :active="route().current('glossary.*')" :href="route('glossary.index')">
                            مصطلحات الفوركس
                        </ResponsiveNavLink> -->
                        <ResponsiveNavLink :active="route().current('faqs')" :href="route('faqs.index')">
                            الأسئلة الشائعة
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :active="route().current('about')" :href="route('about')">
                            من نحن
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream && $page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img :alt="$page.props.auth.user.name" :src="$page.props.auth.user.profile_photo_url"
                                     class="h-10 w-10 rounded-full object-cover">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :active="route().current('dashboard')" :href="route('dashboard')">
                                اللوحة الرئيسية
                            </ResponsiveNavLink>

                            <!-- <ResponsiveNavLink :active="route().current('profile.show')" :href="route('profile.show')">
                                حسابي
                            </ResponsiveNavLink> -->

                            <ResponsiveNavLink v-if="$page.props.jetstream && $page.props.jetstream.hasApiFeatures"
                                               :active="route().current('api-tokens.index')"
                                               :href="route('api-tokens.index')">
                                توكن
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    تسجيل الخروج
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream && $page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200"/>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    ادارة الفريق
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :active="route().current('teams.show')"
                                                   :href="route('teams.show', $page.props.auth.user.current_team)">
                                    اعدادات الفريق
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream && $page.props.jetstream.canCreateTeams"
                                                   :active="route().current('teams.create')"
                                                   :href="route('teams.create')">
                                    انشاء فريق جديد
                                </ResponsiveNavLink>

                                <div class="border-t border-gray-200"/>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    تغيير الفريق
                                </div>

                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.auth.user.current_team_id"
                                                     class="me-2 h-5 w-5 text-green-400" fill="none"
                                                     stroke="currentColor" stroke-linecap="round"
                                                     stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                    <!-- Responsive Auth Options -->
                    <div v-else class="py-6 px-5 space-y-6">
                        <Link v-if="$page.props.canRegister" :href="route('register')"
                              class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700">
                            مستخدم جديد
                        </Link>
                        <p v-if="$page.props.canRegister" class="mt-6 text-center text-base font-medium text-gray-500">
                            هل لديك حساب بالفعل؟
                            {{ ' ' }}
                            <Link :href="route('login')" class="text-primary-600 hover:text-primary-500">
                                تسجيل الدخول
                            </Link>
                        </p>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div>
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>

        <FooterSocialLinksOnly/>
    </div>
</template>
