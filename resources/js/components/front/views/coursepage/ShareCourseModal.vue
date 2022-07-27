<template>
    <alert-dialog :show="show" title="مشاركة" @close="closeModal" :portal="portal">
        <template>
            <div class="share-course-modal">
                <div class="social-list d-flex flex-wrap justify-center">
                    <div class="mo">
                        <!-- :description=description -->
                        <ShareNetwork
                            network="whatsapp"
                            :url="courseUrl"
                            :title="courseName"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <img src="/images/whatsapp-icon.svg" width="50" height="50">
                        </ShareNetwork>
                    </div>
                        <ShareNetwork
                            network="facebook"
                            :url="courseUrl"
                            :title="courseName"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <img src="/images/facebook-icon.svg" width="50" height="50">
                        </ShareNetwork>
                        <div class="mo">
                            <ShareNetwork
                                network="messenger"
                                :url="courseUrl"
                                :title="courseName"
                                :quote="description"
                                :hashtags="hashTags"
                                :twitterUser="twitterUser"
                                >
                                <img src="/images/messenger-icon.svg" width="50" height="50">
                            </ShareNetwork>
                        </div>
                        <ShareNetwork
                            network="twitter"
                            :url="encodedUrl"
                            :title="courseName"
                            :quote="description"
                            :hashtags="courseName"
                            :twitterUser="twitterUser"
                            >
                            <img src="/images/twitter-icon.svg" width="50" height="50">
                        </ShareNetwork>
                        <ShareNetwork
                            network="linkedin"
                            :url="courseUrl"
                            :title="courseName"
                            :quote="description"
                            :hashtags="hashTags"
                            :twitterUser="twitterUser"
                            >
                            <img src="/images/linkedin-icon.svg" width="50" height="50">
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
    props: ['show','courseName','hashTags','description','quote','twitterUser','portal'],
    computed: {
        courseUrl(){
            return `${decodeURI(window.location.href)}`
        },
        encodedUrl(){
            return `${encodeURI(window.location.href)}`
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