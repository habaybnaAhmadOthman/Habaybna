<template>
    <router-link :to="`/specialist/${specialist.firstName.split(' ').join('-')}`" class="specialist-card bg-white shadow pt-20 pb-30 radius-10" :class="{'active':!showMore}">
        <figure class="d-flex center">
            <img :src="specialist.avatar | defaultAvatar" class="m-side-auto object-fit overflow-hidden rounded avatar" width="170" height="170" alt="">
        </figure>
        <div class="details">
            <p class="black-2 mt-20 mt-10-p mb-10-p font-22 font-20-p bold mb-15 center">{{specialist.firstName + ' ' + (specialist.lastName || '')}}</p>
            <p class="regular font-22 font-18-p mb-5-p black-2 mb-15 desc center" v-if="specialist.specialization">{{specialist.specialization}}</p>
            <span class="yellow font-20 center bold pointer" @click="showMoreFn" v-if="showMore">المزيد</span>
        </div>
        <!-- <div class="d-flex p-side-30" v-if="specialist.bio">
            <span class="yellow font-20 bold pointer justify-center-p" @click="showMoreFn" v-else>أقل</span>
        </div> -->
    </router-link>
</template>

<script>
    export default {
        props: ['specialist'],
        data:()=> ({
            showMore: true
        }),
        methods: {
            showMoreFn(){
                this.showMore = !this.showMore
            }
        },
        filters: {
            defaultAvatar: function (avatar) {
                if (avatar == 'default.jpg') return '/images/avatars/default.jpg'
                return avatar
            }
        }
    }
</script>

<style scoped>
.details {
    padding-left: 40px;
    padding-right: 40px;
}
.specialist-card {
    align-self: baseline;
}
.desc {
    max-height: 66px;
    overflow: hidden;
}
.desc {
    max-height: 66px;
    overflow: hidden;
}
.specialist-card.active .desc {
    max-height: inherit;
}
@media (max-width: 767px) {
    .avatar {
        width: 140px;
        height: 140px;
    }
}
</style>