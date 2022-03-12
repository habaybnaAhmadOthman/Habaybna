<template>
    <alert-dialog :show="show" title="مشاركة الكورس" @close="closeModal">
        <template>
            <div class="share-course-modal">
                <div class="social-list d-flex flex-wrap justify-center">
                        <ShareNetwork
                            network="whatsapp"
                            :url="courseUrl"
                            :title="courseName"
                            :description="description"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <div class="social-box d-flex align-center radius-10 white whats overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/whatsapp-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">واتساب</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="facebook"
                            :url="courseUrl"
                            :title="courseName"
                            :description="description"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <div class="social-box d-flex align-center radius-10 white facebook overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/facebook-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">فيسبوك</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="messenger"
                            :url="courseUrl"
                            :title="courseName"
                            :description="description"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
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
                            :url="courseUrl"
                            :title="courseName"
                            :description="description"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <div class="social-box d-flex align-center radius-10 white twitter overflow-hidden">
                                <div class="d-flex">
                                    <img src="/images/twitter-icon.svg" width="20" height="20">
                                </div>
                                <span class="pr-10">تويتر</span>
                            </div>
                        </ShareNetwork>
                        <ShareNetwork
                            network="linkedin"
                            :url="courseUrl"
                            :title="courseName"
                            :description="description"
                            :quote="description"
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
            return `${window.location.href}`
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