<template>
    <alert-dialog :show="show" title="مشاركة الكورس" @close="closeModal">
        <template>
            <div class="share-course-modal">
                <div class="social-list d-flex flex-wrap justify-center">
                        <ShareNetwork
                            network="twitter"
                            url="https://www.arabiaweather.com/ar/content/%D9%83%D9%85%D9%8A%D8%A7%D8%AA-%D8%A7%D9%84%D8%A3%D9%85%D8%B7%D8%A7%D8%B1-%D8%A7%D9%84%D9%85%D8%B3%D8%AC%D9%84%D8%A9-%D9%81%D9%8A-%D8%A7%D9%84%D8%A3%D8%B1%D8%AF%D9%86-%D9%85%D9%86-%D8%B8%D9%8F%D9%87%D8%B1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-%D9%88%D8%AD%D8%AA%D9%89-%D8%A7%D9%84%D8%B3%D8%A7%D8%B9%D8%A9-815-%D9%85%D9%86-%D9%85%D8%B3%D8%A7%D8%A1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-3-3"
                            title="فن الكلام والخبرة المجتمعية"
                            description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                            quote="The hot reload is so fast it\'s near instant. - Evan You"
                            hashtags="كورس,توحد"
                            twitterUser="zalloum"
                            >
                            <div class="social-box d-flex align-center radius-10 white whats overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/whatsapp-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">واتساب</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="twitter"
                            url="https://www.arabiaweather.com/ar/content/%D9%83%D9%85%D9%8A%D8%A7%D8%AA-%D8%A7%D9%84%D8%A3%D9%85%D8%B7%D8%A7%D8%B1-%D8%A7%D9%84%D9%85%D8%B3%D8%AC%D9%84%D8%A9-%D9%81%D9%8A-%D8%A7%D9%84%D8%A3%D8%B1%D8%AF%D9%86-%D9%85%D9%86-%D8%B8%D9%8F%D9%87%D8%B1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-%D9%88%D8%AD%D8%AA%D9%89-%D8%A7%D9%84%D8%B3%D8%A7%D8%B9%D8%A9-815-%D9%85%D9%86-%D9%85%D8%B3%D8%A7%D8%A1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-3-3"
                            title="فن الكلام والخبرة المجتمعية"
                            description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                            quote="The hot reload is so fast it\'s near instant. - Evan You"
                            hashtags="كورس,توحد"
                            twitterUser="zalloum"
                            >
                            <div class="social-box d-flex align-center radius-10 white facebook overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/facebook-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">فيسبوك</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="twitter"
                            url="https://www.arabiaweather.com/ar/content/%D9%83%D9%85%D9%8A%D8%A7%D8%AA-%D8%A7%D9%84%D8%A3%D9%85%D8%B7%D8%A7%D8%B1-%D8%A7%D9%84%D9%85%D8%B3%D8%AC%D9%84%D8%A9-%D9%81%D9%8A-%D8%A7%D9%84%D8%A3%D8%B1%D8%AF%D9%86-%D9%85%D9%86-%D8%B8%D9%8F%D9%87%D8%B1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-%D9%88%D8%AD%D8%AA%D9%89-%D8%A7%D9%84%D8%B3%D8%A7%D8%B9%D8%A9-815-%D9%85%D9%86-%D9%85%D8%B3%D8%A7%D8%A1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-3-3"
                            title="فن الكلام والخبرة المجتمعية"
                            description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                            quote="The hot reload is so fast it\'s near instant. - Evan You"
                            hashtags="كورس,توحد"
                            twitterUser="zalloum"
                            >
                            <div class="social-box d-flex align-center radius-10 white messenger overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/messenger-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">ماسنجر</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="twitter"
                            url="https://www.arabiaweather.com/ar/content/%D9%83%D9%85%D9%8A%D8%A7%D8%AA-%D8%A7%D9%84%D8%A3%D9%85%D8%B7%D8%A7%D8%B1-%D8%A7%D9%84%D9%85%D8%B3%D8%AC%D9%84%D8%A9-%D9%81%D9%8A-%D8%A7%D9%84%D8%A3%D8%B1%D8%AF%D9%86-%D9%85%D9%86-%D8%B8%D9%8F%D9%87%D8%B1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-%D9%88%D8%AD%D8%AA%D9%89-%D8%A7%D9%84%D8%B3%D8%A7%D8%B9%D8%A9-815-%D9%85%D9%86-%D9%85%D8%B3%D8%A7%D8%A1-%D9%8A%D9%88%D9%85-%D8%A7%D9%84%D8%AE%D9%85%D9%8A%D8%B3-3-3"
                            title="فن الكلام والخبرة المجتمعية"
                            description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                            quote="The hot reload is so fast it\'s near instant. - Evan You"
                            hashtags="كورس,توحد"
                            twitterUser="zalloum"
                            >
                            <div class="social-box d-flex align-center radius-10 white twitter overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/twitter-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">تويتر</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="twitter"
                            :url="courseUrl"
                            :title="courseName"
                            :description="description"
                            :quote="quote"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <div class="social-box d-flex align-center radius-10 white linkedin overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/linkedin-icon.svg" width="20" height="20">
                                </div>               
                                <span class="pr-10">لينكد ان</span>
                            </div>
                        </ShareNetwork>
                </div>
            </div>
        </template>
        <template #actions>
            <button class="btn ml-25" @click="closeModal">إغلاق</button>
        </template>
    </alert-dialog>
</template>

<script>
export default {
    emits: ["close-share-modal"],
    props: ['show','courseName','hashTags','description','quote','twitterUser'],
    computed: {
        courseUrl(){
            return `http://test.habaybna.ps/`
        }
    },
    methods: {
        closeModal(){
            this.$emit('close-share-modal')
        },
    }
};
</script>
<style scoped>
.social-list{
    column-gap: 25px;
    row-gap: 25px;
}
.social-box {
    min-width: 120px;
    border-radius: 4px;
}
.social-box div {
    padding: 5px;
}
.whats {
    background: #25d366;
}
.whats div {
    background: #1ea952;
}
.facebook {
    background: #1877f2;
}
.facebook div {
    background: #145fc2;
}
.messenger {
    background: #0183ff;
}
.messenger div {
    background: #0369cd;
}
.twitter {
    background: #1da1f2;
}
.twitter div {
    background: #1981c1;
}
.linkedin {
    background: #017bb5;
}
.linkedin div {
    background: #036291;
}
</style>