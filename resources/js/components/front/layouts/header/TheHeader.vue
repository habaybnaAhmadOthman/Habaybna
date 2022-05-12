<template>
    <header id="header" class="pt-5 pb-5">
        <div class="d-flex align-center space-between">
            <div class="mo w-100-p">
                <div class="d-flex align-center w-100 mobile-top-header space-between">
                    <router-link to="/" class="logo d-flex">
                        <img src="/images/siteImgs/header/logo.png" width="120" />
                    </router-link>
                    <a v-if="$route.meta.back == true" @click.prevent="$router.back()" class="back-btn d-flex" ><img src="/images/back-btn.svg" width="30" /></a>
                </div>
            </div>
            <div class="d-flex align-center w-100 header-right">
                <div class="do">
                    <router-link to="/" class="logo d-flex">
                        <img src="/images/siteImgs/header/logo.png" width="120" />
                    </router-link>
                </div>
                <div class="do w-100">
                    <menu class="d-flex align-center main-menu space-around pl-30">
                        <router-link
                            class="black-2 nowrap p-side-10 h-100 flex-all bold"
                            to="/"
                            >الرئيسية</router-link
                        >
                        <router-link
                            class="black-2 nowrap p-side-10 h-100 flex-all bold"
                            to="/online-courses"
                            >الدورات الرقمية</router-link
                        >
                        <router-link
                            class="black-2 nowrap p-side-10 h-100 flex-all bold"
                            to="/ask-specialists"
                            >الاستشارات مع المختصين</router-link
                        >
                        <router-link
                            class="black-2 nowrap p-side-10 h-100 flex-all bold"
                            to="/library"
                            >مكتبة المعلومات</router-link
                        >
                        <!-- <div class="dropdown relative h-100 flex-all">
                            <router-link
                                class="black-2 nowrap p-side-10 h-100 flex-all bold"
                                to="/library"
                                >مكتبة حبايبنا</router-link
                            >
                            <aside class="radius-5 overflow-hidden trans">
                                <router-link
                                    class="white nowrap d-block trans pt-15 pb-15 p-5"
                                    to="/"
                                    >الفيديوهات</router-link
                                >
                                <router-link
                                    class="white nowrap d-block trans pt-15 pb-15 p-5"
                                    to="/"
                                    >المقالات</router-link
                                >
                                <router-link
                                    class="white nowrap d-block trans pt-15 pb-15 p-5"
                                    to="/"
                                    >مقدمي المحتوى</router-link
                                >
                                <router-link
                                    class="white nowrap d-block trans pt-15 pb-15 p-5"
                                    to="/"
                                    >شارك معنا</router-link
                                >
                            </aside>
                        </div> -->
                        
                    </menu>
                </div>

                <!-- mobile buttons -->
                <template>
                    <router-link to="/" class="home-mo mo center mobile-link">
                        <img src="/images/home-icon.svg" >
                        <p class="font-10 mobile-icon-color">الرئيسية</p>
                    </router-link>
                    <router-link to="/online-courses" class="profile-mo mo center mobile-link">
                        <img src="/images/mo-video-bottom.svg" width="24" height="21" >
                        <p class="font-10 mobile-icon-color">الدورات</p>
                    </router-link>
                    <router-link to="/profile/my-account" class="profile-mo mo center mobile-link">
                        <img src="/images/profile-avatar-mo.svg" >
                        <p class="font-10 mobile-icon-color">حسابي</p>
                    </router-link>
                    <div  class="profile-mo mo center mobile-link">
                        <img src="/images/menu-icon-mobile.svg" @click="toggleMobileMenu">
                        <p class="font-10 mobile-icon-color">المزيد</p>
                    </div>

                </template>
            </div>
            <LeftSide :isMobileMenuOpened="isMobileMenuOpened" :toggleMobileMenu="toggleMobileMenu" @toggleMobileMenu="toggleMobileMenu" :isLoggedIn="isLoggedIn"></LeftSide>
        </div>
    </header>
</template>

<script>
import LeftSide from "./LeftSide.vue";
export default {
    components: {
        LeftSide
    },
    data(){
        return {
            isMobileMenuOpened: false,
        }
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters["user/isLoggedIn"];
        }
    },
    // created() {
    //     window.addEventListener("scroll", this.handleScroll);
    // },
    // destroyed() {
    //     window.removeEventListener("scroll", this.handleScroll);
    // },
    methods: {
        // handleScroll(event) {
        //     // Any code to be executed when the window is scrolled
        //     // console.log(event);
        // },
        // goBack(){
        //     this.$router.back()
        // },
        toggleMobileMenu(){
            this.isMobileMenuOpened = !this.isMobileMenuOpened
        },
        
    }
};
</script>
<style scoped>
header {
    padding-left: 1.2vw;
    padding-right: 1.2vw;
    transition: 0.5s ease-in-out;
    box-shadow: 10px 10px 10px -16px #000;
    position: sticky;
    top: 0;
    width: 100%;
    z-index: 9999;
    background: #fff;
}
.main-menu {
    align-self: stretch;
}
.main-menu > a,
.main-menu .dropdown > a {
    padding: 0 10px;
}
.main-menu > a {
    padding: 24px 10px;
}
.dropdown > aside {
    position: absolute;
    top: 100%;
    min-width: 200px;
    background: #660066;
    box-shadow: 1px 3px 4px 1px #0000004f;
    right: 0;
    visibility: hidden;
    opacity: 0;
}
.lang-en .dropdown > aside {
    right: auto;
    left: 0;
}
.dropdown > aside a:hover {
    background: #fff;
    color: #660066b8;
}
.dropdown:hover > aside {
    visibility: visible;
    opacity: 1;
}
a {
    position: relative;
}
.main-menu .router-link-exact-active:before {
    content: '';
    width: 100%;
    height: calc(100% + 14px);
    background: #E58C00;
    right: 0;
    top: -6px;
    position: absolute;
    z-index: -1;
    box-shadow: 0px 3px 6px #00000029;
}
.main-menu .router-link-exact-active {
    color: #fff!important;
}
.header-right {
    height: 100%;
}
.mobile-icon-color{
    color: #6E6D6D;
}
@media (max-width: 767px) {
    .logo img {
        width:50px;
        height: 34px;
    }
    header {
        padding-left: 12px;
        padding-right: 12px;
        background:#F4F4F4;
        position: relative;
    }
    .header-right {
        justify-content: space-between;
    }
    .mobile-link p {
        margin-top: -7px;
    }
    .header-right {
        position: fixed;
        bottom: 0;
        top: auto;
        padding-left: 12px;
        padding-right: 12px;
        background: #F4F4F4;
        box-shadow: 2px -1px 8px 0px rgb(0 0 0 / 30%);
        right: 0;
        height: 48px;
    }
}
</style>
