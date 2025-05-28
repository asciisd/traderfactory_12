<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { __ } from '@/lib/__.js';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout title="About Us">
        <Head :title="__('About Us')" />
        <div class="space-y-24 px-6 py-32 lg:px-8">
            <div class="mx-auto max-w-3xl text-base leading-7">
                <h1 class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">من نحن:</h1>
                <p class="mt-6 leading-8">
                    مرحبًا بك في تريدر فاكتوري، حيث بوابتك الحقيقية لاحتراف عالم تداول الفوركس، فنحن نعي تمامًا، في هذا العالم النابض بالحركة، حجم
                    التحدي الذي قد يفرضهما عاملا الزمان والمكان في اكتساب المعرفة. لذا، فقد عملنا على وضع تصورٍ جديدٍ لتعليم الفوركس، يكون مريحًا،
                    وتفاعليًا، وسهل المنال للجميع، فأكاديميتنا لتعليم الفوركس على الانترنت تقدم للراغبين باقة كبيرة من الخدمات المتنوعة، التي صُممت
                    خصيصًا لتوجيهك من بداية رحلة التعلم وحتى تحقيق النجاح المالي.
                </p>
            </div>
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto grid max-w-2xl grid-cols-1 items-start gap-x-8 gap-y-16 sm:gap-y-24 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                    <div class="lg:pr-4">
                        <div
                            class="relative overflow-hidden rounded-3xl px-6 pt-64 pb-9 shadow-2xl sm:px-12 lg:max-w-lg lg:px-8 lg:pb-8 xl:px-10 xl:pb-10"
                        >
                            <img
                                alt=""
                                class="absolute inset-0 h-full w-full object-cover brightness-125 saturate-0"
                                src="https://images.unsplash.com/photo-1630569267625-157f8f9d1a7e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2669&q=80"
                            />
                            <div class="absolute inset-0 mix-blend-multiply" />
                            <div aria-hidden="true" class="absolute top-1/2 left-1/2 -ml-16 -translate-x-1/2 -translate-y-1/2 transform-gpu blur-3xl">
                                <div
                                    class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-40"
                                    style="
                                        clip-path: polygon(
                                            74.1% 44.1%,
                                            100% 61.6%,
                                            97.5% 26.9%,
                                            85.5% 0.1%,
                                            80.7% 2%,
                                            72.5% 32.5%,
                                            60.2% 62.4%,
                                            52.4% 68.1%,
                                            47.5% 58.3%,
                                            45.2% 34.5%,
                                            27.5% 76.7%,
                                            0.1% 64.9%,
                                            17.9% 100%,
                                            27.6% 76.8%,
                                            76.1% 97.7%,
                                            74.1% 44.1%
                                        );
                                    "
                                />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-base leading-7 lg:max-w-lg">
                            <h1 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">المهمة:</h1>
                            <div class="max-w-xl">
                                <p class="mt-6">
                                    نعمل في تريدر فاكتوري على صياغة تعريفات جديدة لكيفية تعلم تداول الفوركس، لجعله أكثر متعة، ونقطة فارقة في حياتك.
                                    ونتعهد لك بتوفير تجربة تعليمية حيوية ومبتكرة، عبر مجموعة مميزة من مقاطع فيديو متحركة تفاعلية قصيرة، وذلك لاعتقادنا
                                    بأن أساليب التعليم التقليدية قد تكون مملة ومصمتة. وتتركز مهمتنا على مساعدة الأفراد على التغلب على قيودهم المالية
                                    عبر تزويدهم بالمعرفة، والثقة بالنفس اللازمتين لتحقيق النجاح في عالم تداول الفوركس سريع الوتيرة.
                                </p>
                            </div>
                            <h1 class="mt-8 text-3xl font-bold tracking-tight sm:text-4xl">الرؤية:</h1>
                            <div class="max-w-xl">
                                <p class="mt-6">
                                    تعكس رؤيتنا في تريدر فاكتوري رغبتنا في أن نكون حافزًا نحو التحول المالي في الوطن العربي، إذ نطمح في أن نكون قبلة
                                    الراغبين في تعلم تداول الفوركس عبر سبل تفاعلية وفاعلة. إننا نطمح في مستقبل لا يقتصر فيه تعليم الفوركس على قلة
                                    مختارة، بل يمكن لكل الراغبين في تحقيق الاستقلال المالي الوصول إليه بسهولة ويسر. وفي سبيل هذا، نسعى دون كلل لوضع
                                    قواعد جديدة لتعليم الفوركس على الإنترنت، أساسها الابتكار المستمر، والتفاني، والالتزام بالتميز.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
