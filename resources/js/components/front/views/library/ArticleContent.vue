<template>
    <div class="">
        <div class="box mt-30 flex-wrap-p p-side-12-p">
            <div class=" content w-100-p">
                <h1 class="font-40 bold black font-28-p">تعليم الطفل المتأخر في النطق واللغة مهارة التصنيف</h1>
                <div class="author-box bold mb-20 mt-10 d-flex align-center">
                    <img src="/images/test.jpg" class="object-fit rounded" width="40" height="40">
                    <div class="mr-10">
                        <p class="font-14 main-color">سعاد الدميري</p>
                        <p class="font-14 yellow">اختصاصية علاج طبيعي</p>
                    </div>
                </div>
                <div class="font-20 black-2 font-18-p">مهارة التصنيف نستعملها كثيراً في علاجات الأطفال ذوي الصعوبات اللغوية التطورية وكذلك مع الأشخاص الذين يعانون من الأفازيا (صعوبة لغوية بعد اصابة دماغية). لذلك تتحدث أخصائية النطق واللغة سهاد بشارة في هذه المقالة عن أهمية وفائدة هذه المهارة وطرق تعليمها. إليكم عدة نقاط توضح أهمية مهارة التصنيف للغة الطفل: -تمنحنا مهارة التصنيف طريقة لتجميع أفكارنا ومعالجة المعلومات وتخزين الأفكار واستراجاعها ووصف العناصر. -يعد تصنيف الكلمات والصور إلى مجموعات طريقة رائعة لبناء وتوسيع المفردات. -تعلم مفردات جديدة حسب المجموعات ويساعد الطفل على تخزينها بشكل أفضل. -يعتبر التصنيف طريقة رائعة لمعالجة صعوبات في تخزين الكلمات وتذكرها. نستعرض الآن 6 طرق للتمرن على تصنيف الكلمات إلى مجموعات: -مقارنات بين صورتين -تصنيف صور أو كلمات لمجموعات -ما هي الصورة أو الكلمة الشاذة؟ -ما هي إسم المجموعة التي تنتمي إليها هذه الصورة أو الكلمة؟ -أي صور أو كلمات يتماشوا مع بعضهم -تسمية كلمات تابعة للمجموعة</div>
                <div class="tags mt-30 d-flex flex-wrap align-center">
                    <p class="bold ml-20">السمات: </p>
                    <div class="gap-10 d-flex flex-wrap">
                        <Tag :value="'التحديات الذهنية'"></Tag>
                    </div>   
                </div>
            </div>
            <!-- <div class="left-side-col w-100-p mt-20-p">
                <div class="floating-ads">
                    <div class="shadow-2 radius-10 ad-box bg-yellow p-10 mpu">
                        ad 1 
                    </div>
                    <div class="shadow-2 radius-10 ad-box bg-soft p-10 mt-15 mpu">
                        ad 2
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
    import Tag from '../../layouts/Tag.vue'
    export default {
        components: {
            Tag
        }
    }
</script>

<style scoped>
.main-img {
    max-height: 700px;
}
.floating-ads {
    position: sticky;
    top: 10px;
}
@media (max-width: 767px) { 

}
</style>