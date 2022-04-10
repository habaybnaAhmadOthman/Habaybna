<template>
    <header id="header" class="pt-5 pb-5">
        <div class="d-flex align-center space-between">
            <div class="d-flex align-center">
                <router-link to="/" class="logo d-flex">
                    <img src="/images/siteImgs/header/logo.png" width="120" />
                </router-link>
                <div class="do">
                    <menu class="d-flex align-center main-menu">
                        <router-link
                            class="black nowrap p-side-10 h-100 flex-all bold"
                            to="/"
                            >الرئيسية</router-link
                        >
                        <router-link
                            class="black nowrap p-side-10 h-100 flex-all bold"
                            to="/profile"
                            >حسابي</router-link
                        >
                        <div class="dropdown relative h-100 flex-all">
                            <router-link
                                class="black nowrap p-side-10 h-100 flex-all bold"
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
                        </div>
                        <router-link
                            class="black nowrap p-side-10 h-100 flex-all bold"
                            to="/"
                            >دليل حبايبنا</router-link
                        >
                        <router-link
                            class="black nowrap p-side-10 h-100 flex-all bold"
                            to="/"
                            >إسأل الأخصائيين</router-link
                        >
                        <router-link
                            class="black nowrap p-side-10 h-100 flex-all bold"
                            to="/"
                            >من نحن</router-link
                        >
                        <router-link
                            class="black nowrap p-side-10 h-100 flex-all bold"
                            to="/online-courses"
                            >الدورات التدريبية</router-link
                        >
                    </menu>
                </div>
            </div>
            <LeftSide :isLoggedIn="isLoggedIn"></LeftSide>
        </div>
    </header>
</template>

<script>
import LeftSide from "./LeftSide.vue";
export default {
    components: {
        LeftSide
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters["user/isLoggedIn"];
        }
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    methods: {
        handleScroll(event) {
            // Any code to be executed when the window is scrolled
            // console.log(event);
        }
    }
};
</script>
<style scoped>
header {
    padding-left: 1.2vw;
    padding-right: 1.2vw;
    transition: 0.5s ease-in-out;
    box-shadow: 10px 10px 10px -16px #000;
    position: relative;
    top: 0;
    width: 100%;
    z-index: 10;
    background: #fff;
}
.main-menu {
    align-self: stretch;
}
.main-menu > a,
.main-menu .dropdown > a {
    padding: 0 10px;
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
@media (max-width: 767px) {
    .logo img {
        width:50px;
        height: 34px;
    }
    header {
        padding-left: 12px;
        padding-right: 12px;
        background:#F4F4F4;
    }
    
}
</style>
