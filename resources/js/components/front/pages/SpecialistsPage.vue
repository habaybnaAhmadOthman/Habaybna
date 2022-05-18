<template>
    <div class="ask-specialists-page">
        <TheHeader></TheHeader>
            <div class="container p-side-12-p mt-20">
                <h2 class="title-line mb-40 mb-20-p">الاستشارات مع المختصين</h2>
                <h2 class="mb-10">أهلا بكم في خدمة الاستشارات مع المختصين</h2>
                <p class="mb-10">لأن لكل طفل ولكل والدين رحلتهم الخاصة المختلفة عن غيرهم، وفرنا خدمة الاستشارات مع المختصين لإتاحة الفرصة للوالدين ومقدمي الرعاية الاتصال مع أحد الأخصائيين والحصول على التوجيه الفردي الملائم لحالة طفلهم حسب احتياجاته التطورية.</p>

                <p>هذه الخدمة عن بعد، وهي متاحة للوالدين ومقدمي الرعاية في أي وقت يحتاجون فيه التوجيه والإرشاد ومن أي مكان هم فيه.</p>

                <p class="mb-30">تم تقديم أكثر من 1450 مكالمة خلال العامين الماضيين للأهالي العرب في الأردن وعدد من الدول الأخرى حول العالم وقد مكنت العديد منهم للتعامل مع التحديات التي يواجهونها مع أبنائهم المتأخرين في التطور.</p>
                <p class="title-line font-20 mb-20">حالياً يقدم هذه الاستشارات</p>
                <ul class="li-auto p-side-20 mb-10">
                    <li>أخصائيين في النطق واللغة</li>
                    <li>أخصائيين في العلاج الوظيفي</li>
                    <li>أخصائيين التربية الخاصة</li>
                    <li>أخصائيين في الإرشاد الأسري</li>
                </ul>
                <p class="mb-30"><span class="bold">مدة المكالمة:</span> 20 دقيقة</p>
                <p>سيتم إطلاق هذه الخدمة بشكل رسمي قريباً على موقع حبايبنا.نت، إذا كنتم مهتمين بهذه الخدمة برجاء تبعئة النموذج التالي لنقوم بإرسال تنبيه لكم فور إطلاق الخدمة على الموقع</p>
                <a @click="goToLink(`https://forms.gle/bDJivouh3AWmXkUH8`)">
                    النموذج: https://forms.gle/bDJivouh3AWmXkUH8
                </a>
                <p class="mt-20 mb-10"><span class="bold">ملاحظة:</span> “جميع المعلومات في هذا النموذج والمعلومات التي ستشاركوها عبر المكالمة ستعامل بسرية تامة.</p>
                <p>سعداء بثقتكم و نتمنى أن نكون جزء جميل من رحلتكم في تمكين أبنائنا بمختلف قدراتهم</p>
                <p>فريق حبايبنا.نت</p>
            </div>

        <TheFooter></TheFooter>
    </div>
</template>

<script>
    import TheHeader from '../layouts/header/TheHeader.vue';
    import TheFooter from '../layouts/TheFooter.vue';
    export default {
        components: { TheHeader,TheFooter},
        methods: {
            goToLink(url) {
                window.open(url,'_blank')
            }
        }
    }
</script>
<style scoped>
h1 {
    font-size: 100px;
}
</style>
