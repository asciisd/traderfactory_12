<script setup lang="ts">
import { BoltIcon, GlobeAltIcon, ScaleIcon } from '@heroicons/vue/24/outline';

const transferFeatures = [
    {
        id: 1,
        name: 'البورصة وأسواق المال',
        description:
            'في هذا القسم يتم تدريس مقدمة  عن ماهية البورصة و أنواعها ، إلى جانب المميزات التي من الممكن أن تعود عليك كمستثمر في البورصة و التعرف على الأنظمة المستخدمة في سوق العملات كنظام الهوامش و الروافع المالية ، و المعلومات التاريخية لهذا السوق و كيف أصبحت أحد أهم أسواق الاستثمار في الوقت الحالي',
        icon: GlobeAltIcon,
    },
    {
        id: 2,
        name: 'علوم التحليل والأدوات المالية',
        description:
            'في هذا القسم ندخل بشئ من التفصيل في علوم الاستثمار و توقع حركة السعر في المستقبل باستخدام التحليل الأساسي ( الاقتصادي ) في البورصة وندرس ايضا التحليل الفني و هو أحد أشهر سُبل التحليل في البورصة في الوقت الحالي  و ستتعلم في هذا القسم ماهية التحليل الفني وكيف تسير حركة الاسعار  و كيفية قراءة الرسوم البيانية و تحديد الاتجاهات وانعكاساتها ، حتى تستطيع تطوير نفسك بعد ذلك في هذا العلم الى أن تصبح مضارب محترف',
        icon: ScaleIcon,
    },
    {
        id: 3,
        name: 'علوم إدارة رأس المال والمخاطر',
        description:
            'دراسة كيفية إدارة رأس المال الخاص بك وكيفية تحديد المخاطر ونوعها وطريقة التعامل معها بشكل علمي حتى يستطيع تحقيق أفضل النتائج الربحية على المدى البعيد',
        icon: BoltIcon,
    },
];
</script>

<template>
    <div>
        <div class="relative mx-auto max-w-xl px-6 lg:max-w-7xl lg:px-8">
            <svg
                aria-hidden="true"
                class="absolute right-full hidden translate-x-1/2 translate-y-12 transform lg:block"
                fill="none"
                height="784"
                viewBox="0 0 404 784"
                width="404"
            >
                <defs>
                    <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" height="20" patternUnits="userSpaceOnUse" width="20" x="0" y="0">
                        <rect class="text-foreground/20" fill="currentColor" height="4" width="4" x="0" y="0" />
                    </pattern>
                </defs>
                <rect fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" height="784" width="404" />
            </svg>

            <div class="relative">
                <h2 class="text-center text-3xl leading-8 font-bold tracking-tight sm:text-4xl">
                    أفضل طريقة لتعلم التداول هو ان تتداول بنفسك.. هل أنت جاهز؟
                </h2>
                <p class="mx-auto mt-4 max-w-3xl text-center text-xl">
                    أكاديمية تريدر فاكتوري هي أحد مصادر التدريب العلمي والعملي لأسواق المال
                </p>
            </div>

            <div class="relative mt-12 lg:mt-24 lg:grid lg:grid-cols-2 lg:items-center lg:gap-8">
                <div class="relative">
                    <h3 class="text-2xl font-bold tracking-tight sm:text-3xl">
                        تدرب على استخدام أحدث أساليب التداول والاستثمار في أسواق المال
                    </h3>
                    <p class="mt-3 text-lg">
                        صممت الأكاديمية بشكل ممنهج لتدريبك على استخدام أحدث أساليب التداول والاستثمار في أسواق المال عن طريق دراسة العلوم المطلوبة
                        للنجاح في رحلة احتراف التداول
                    </p>

                    <dl class="mt-10 space-y-10">
                        <div v-for="item in transferFeatures" :key="item.id" class="relative">
                            <dt>
                                <div class="absolute flex h-12 w-12 items-center justify-center rounded-xl">
                                    <component :is="item.icon" aria-hidden="true" class="h-8 w-8" />
                                </div>
                                <p class="ms-16 text-lg leading-6 font-bold">{{ item.name }}</p>
                            </dt>
                            <dd class="ms-16 mt-2 text-base">{{ item.description }}</dd>
                        </div>
                    </dl>
                </div>

                <div aria-hidden="true" class="relative -mx-4 mt-10 lg:mt-0">
                    <svg
                        class="absolute left-1/2 -translate-x-1/2 translate-y-16 transform lg:hidden"
                        fill="none"
                        height="404"
                        viewBox="0 0 784 404"
                        width="784"
                    >
                        <defs>
                            <pattern id="ca9667ae-9f92-4be7-abcb-9e3d727f2941" height="20" patternUnits="userSpaceOnUse" width="20" x="0" y="0">
                                <rect class="text-foreground/20" fill="currentColor" height="4" width="4" x="0" y="0" />
                            </pattern>
                        </defs>
                        <rect fill="url(#ca9667ae-9f92-4be7-abcb-9e3d727f2941)" height="404" width="784" />
                    </svg>
                    <img
                        alt=""
                        class="relative mx-auto w-full"
                        src="https://s3.eu-central-1.amazonaws.com/traderfactory.com/guest/trader_factory_section.png"
                        width="490"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
