<template>
    <Popover class="z-20" open="true">
        <div
            class="flex max-w-7xl mx-auto justify-between items-center px-4 py-6 sm:px-6 md:justify-start md:space-x-10 rtl:space-x-reverse">
            <div>
                <Link :href="route('welcome')" class="flex">
                    <span class="sr-only">Traderfactory</span>
                    <application-logo-light class="h-8 w-auto sm:h-10"/>
                </Link>
            </div>
            <div class="hidden space-x-8 rtl:space-x-reverse sm:-my-px sm:ms-10 sm:flex">
                <Link
                    v-for="item in navigation"
                    :key="item.href"
                    :href="item.href"
                    class="text-base font-medium text-white hover:text-gray-300"
                >
                    {{ item.name }}
                </Link>
            </div>
            <div class="-ms-2 -my-2 md:hidden">
                <PopoverButton
                    class="bg-transparent rounded-md p-2 inline-flex items-center justify-center text-white hover:bg-transparent focus:outline-none focus:ring-2 focus-ring-inset focus:ring-white">
                    <span class="sr-only">Open menu</span>
                    <Bars3Icon aria-hidden="true" class="h-6 w-6"/>
                </PopoverButton>
            </div>

            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                <PopoverGroup as="nav" class="flex space-x-10 rtl:space-x-reverse">
                </PopoverGroup>
                <div v-if="$page.props.canRegister" class="flex items-center md:ms-12">
                    <primary-link-button v-if="$page.props.auth.user" :href="route('dashboard')"
                                         class="ms-8">
                        لوحة التحكم
                    </primary-link-button>
                    <template v-else>
                        <secondary-link-button v-if="$page.props.canRegister" :href="route('login')">تسجيل الدخول
                        </secondary-link-button>
                        <primary-link-button v-if="$page.props.canRegister" :href="route('register')" class="ms-8">
                            مستخدم جديد
                        </primary-link-button>
                    </template>
                </div>
            </div>
        </div>

        <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <PopoverPanel class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden" focus>
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <Link :href="route('welcome')" class="flex">
                                    <span class="sr-only">Goethe</span>
                                    <application-logo class="h-8 w-auto"/>
                                </Link>
                            </div>
                            <div class="-me-2">
                                <PopoverButton
                                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-white-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                                    <span class="sr-only">Close menu</span>
                                    <XMarkIcon aria-hidden="true" class="h-6 w-6"/>
                                </PopoverButton>
                            </div>
                        </div>
                    </div>
                    <div class="py-6 px-5">
                        <div class="grid grid-cols-2 gap-4">
                            <Link v-for="item in navigation" :key="item.name" :href="item.href"
                                  class="text-base font-medium text-gray-900 hover:text-gray-700">{{
                                    item.name
                                }}
                            </Link>
                        </div>
                        <div v-if="$page.props.canRegister" class="mt-6">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                  class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700">
                                لوحة التحكم
                            </Link>
                            <template v-else>
                                <Link v-if="$page.props.canRegister" :href="route('register')"
                                      class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700">
                                    مستخدم جديد
                                </Link>
                                <p v-if="$page.props.canRegister"
                                   class="mt-6 text-center text-base font-medium text-gray-500">
                                    هل لديك حساب بالفعل؟
                                    {{ ' ' }}
                                    <Link :href="route('login')"
                                          class="text-primary-600 hover:text-primary-500">
                                        تسجيل الدخول
                                    </Link>
                                </p>
                            </template>
                        </div>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>

<script setup>
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'
import ApplicationLogoLight from "@/components/ApplicationLogoLight.vue";
import ApplicationLogo from "@/components/ApplicationLogo.vue";
import PrimaryLinkButton from "@/components/buttons/PrimaryLinkButton.vue";
import SecondaryLinkButton from "@/components/buttons/SecondaryLinkButton.vue";
import {Link} from '@inertiajs/vue3';
import Rank1 from "@/components/icons/Rank1.vue";
import Rank2 from "@/components/icons/Rank2.vue";
import Rank3 from "@/components/icons/Rank3.vue";

const navigation = [
    {name: 'الدورات', href: route('courses.index')},
    {name: 'الندوات', href: route('webinars')},
    {name: 'الكتب', href: route('books.index')},
    {name: 'الأدوات', href: route('tools.index')},
    {name: 'الأسئلة الشائعة', href: route('faqs.index')},
    {name: 'عن الأكاديمية', href: route('about')},
];

const solutions = [
    {
        name: 'المستوى التمهيدي',
        description: '',
        href: '#',
        icon: Rank1,
    },
    {
        name: 'المستوى المتوسط',
        description: '',
        href: '#',
        icon: Rank2,
    },
    {
        name: 'المستوى المتقدم',
        description: '',
        href: '#',
        icon: Rank3,
    }
];
</script>
