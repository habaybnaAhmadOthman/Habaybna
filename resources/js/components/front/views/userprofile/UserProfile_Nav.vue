<template>
    <aside class="user-side-nav bg-white z-1">
        <img
            src="/images/close-icon.svg"
            width="30"
            height="30"
            @click="closeNavMenu"
            class="close-nav-menu mo"
        />
        <ul class="user-side-nav-list">
            <li class="mo">
                <router-link class="d-block p-side-15 pt-10 pb-10 trans"  to="/"
                    >الصفحة الرئيسية</router-link
                >
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans"  to="/profile/my-account" @click.native="closeNavMenu"
                    >إعدادات الحساب</router-link
                >
            </li>
            <!-- <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/" @click.native="closeNavMenu"
                    >حساب الطفل</router-link
                >
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/" @click.native="closeNavMenu"
                    >الإستشارات</router-link
                >
            </li> -->
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/profile/my-courses" @click.native="closeNavMenu"
                    >دوراتي المشترك بها</router-link
                >
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/profile/my-favourite-courses" @click.native="closeNavMenu"
                    >الدورات المفضلة</router-link
                >
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/profile/my-favourite-contents" @click.native="closeNavMenu"
                    >المقالات المفضلة</router-link
                >
            </li>
            <!-- <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/profile/my-favourite-contents" @click.native="closeNavMenu"
                    >المقالات المفضلة</router-link
                >
            </li> -->
            <li class="mo">
                <button @click="logout" class="d-block p-side-15 pt-10 pb-10 trans bg-none w-100 border-0 logout-btn"
                    >تسجيل خروج</button
                >
            </li>
        </ul>
    </aside>
</template>

<script>
export default {
    data() {
        return {
            isMenuOpened: false
        };
    },
    methods: {
        closeNavMenu() {
            document.querySelector(".user-side-nav").classList.remove("active");
        },
        logout(){
            this.$store.dispatch('user/logout');
            if (this.$router.currentRoute.path == "/") {
                this.$store.commit("forceRefresh");
            } else {
                this.$router.push("/")
            }
        }
    }
};
</script>

<style scoped>
.user-side-nav {
    min-width: 230px;
    max-width: 230px;
    color: #686a76;
    box-shadow: -1px 1px 1px rgb(0 0 0 / 10%);
    min-height: calc(100vh - 65px);
}
.user-side-nav-list {
    padding-top: 57px;
}
.user-side-nav li > * {
    border-right: 4px solid transparent;
    color: #212529;
}
.user-side-nav li a.router-link-exact-active,
.user-side-nav li:hover > * {
    background: #660066;
    color: #fff;
    border-color: #b915b9;
}
@media (max-width: 767px) {
    .user-side-nav {
        position: fixed;
        min-width: 100%;
        max-width: none;
        top: 0;
        right: 0;
        transition: 0.3s;
        opacity: 0;
        right: -90%;
        visibility: hidden;
        min-height: 100%;
        max-height: 100%;
        overflow-y: auto;
        z-index: 11;
    }
    .user-side-nav.active {
        opacity: 1;
        right: 0%;
        visibility: visible;
    }
    .close-nav-menu {
        position: absolute;
        top: 20px;
        right: 20px;
    }
    .logout-btn {
        text-align: right;
        color: #3FC4E0!important;
        background: transparent!important;
    }
}
</style>
