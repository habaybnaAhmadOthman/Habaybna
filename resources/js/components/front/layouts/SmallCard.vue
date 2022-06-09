<template>
    <div class="small-card w-100-p relative">
        <!-- <div class="fav-box relative pointer shadow-2" :class="{'active':item.is_favourite}" @click="addToFavourite($event,item.nid)"></div> -->
        <router-link
            class="radius-10 shadow d-flex p-10 bg-white box"
            :to="`/library/${item.title.split(' ').join('-')}`"
        >
            <div class="body ml-15 d-flex flex-column space-between flex-1">
                <p class="black-2 font-20 font-15-p desc three-line">
                    {{ item.title }}
                </p>
                <span
                    class="date font-14 white radius-20 gray"
                    v-if="item.date"
                    >{{ item.date }}</span
                >
            </div>
            <figure class="d-flex relative">
                <!-- favourite -->
                <img
                    class="radius-10 object-fit main-img"
                    :src="item.image"
                    width="100"
                    height="100"
                />
            </figure>
        </router-link>
    </div>
</template>

<script>
export default {
    props: ["item","can-remove"],
    computed: {
        isLoggedIn() {
            return this.$store.getters["user/isLoggedIn"];
        },
    },
    methods: {
        async addToFavourite(event,id) {
            if (this.isLoggedIn) {
                event.target.classList.toggle("active");
                await this.$store.dispatch("content/addToFavourite", {id});
                if (this.$route.name == 'myFavouriteContents') {
                    if (!event.target.classList.contains('active'))
                        event.target.parentNode.remove();
                }

            } else {
                this.$store.commit("loginModal", true);
            }
        },
    },
};
</script>

<style scoped>
.date {
    align-self: baseline;
}
/* .box:after {
    content: '';
    background: url(/images/arrow-left-full.svg) no-repeat center;
    position: absolute;
    left: 15px;
    bottom: 9px;
    margin: auto;
    width: 33px;
    height: 27px;
} */
.fav-box {
    position: absolute;
    background-color: rgb(255 255 255);
    border-radius: 50%;
    left: 124px;
    bottom: 9px;
    width: 34px;
    height: 34px;
    background-image: url(/images/heart-icon.svg);
    background-repeat: no-repeat;
    background-size: 22px 21px;
    background-position: center;
    transition: 0.3s;
    z-index: 1;
}
.fav-box.active {
    background-image: url(/images/heart-icon-fill.svg);
}
.main-img {
    min-width: 100px;
}
.desc {
    line-height: 25px;
}
</style>
