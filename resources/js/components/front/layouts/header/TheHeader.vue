<template>
    <header id="header">
        <div class="d-flex align-center space-between">
            <div class="d-flex align-center">
                <div class="logo">
                    <img src="/images/siteImgs/header/logo.png" />
                </div>
                <menu class="d-flex align-center main-menu">
                    <router-link
                        class="white-i nowrap p-side-10 h-100 flex-all bold"
                        to="/"
                        >الرئيسية</router-link
                    >
                    <div class="dropdown relative h-100 flex-all">
                        <router-link
                            class="white-i nowrap p-side-10 h-100 flex-all bold"
                            to="/"
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
                        class="white-i nowrap p-side-10 h-100 flex-all bold"
                        to="/"
                        >دليل حبايبنا</router-link
                    >
                    <router-link
                        class="white-i nowrap p-side-10 h-100 flex-all bold"
                        to="/"
                        >إسأل الأخصائيين</router-link
                    >
                    <router-link
                        class="white-i nowrap p-side-10 h-100 flex-all bold"
                        to="/"
                        >من نحن</router-link
                    >
                    <router-link
                        class="white-i nowrap p-side-10 h-100 flex-all bold"
                        to="/"
                        >الدورات التدريبية</router-link
                    >
                </menu>
            </div>
            <LeftSide></LeftSide>
        </div>
    </header>
</template>

<script>
import LeftSide from "./LeftSide.vue";
export default {
    components: {
        LeftSide
    }
};
</script>
<style scoped>
header {
    padding-left: 1.2vw;
    padding-right: 1.2vw;
    transition: 0.5s ease-in-out;
    box-shadow: 10px 10px 10px -16px #000;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 10;
}
.main-menu {
    align-self: stretch;
}
.main-menu > a,
.main-menu .dropdown > a {
    min-width: 112px;
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
</style>
