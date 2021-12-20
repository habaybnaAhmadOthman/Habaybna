<template>
    <aside class="user-side-nav bg-white z-1">
        <img
            src="/images/siteImgs/header/logo.png"
            width="20"
            height="20"
            @click="closeNavMenu"
            class="close-nav-menu mo"
        />
        <ul class="user-side-nav-list">
            <slot></slot>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/" @click.native="closeNavMenu"
                    >الصفحة الرئيسية</router-link
                >
            </li>
            <li v-if="isLoggedIn">
                <router-link
                    class="d-block p-side-15 pt-10 pb-10 trans"
                    to="/profile/my-account"
                    >حسابي</router-link
                >
            </li>
            <template v-if="!isLoggedIn">
            <li>
                <router-link
                    class="d-block p-side-15 pt-10 pb-10 trans"
                    to="/signup"
                    >تسجيل</router-link
                >
            </li>
            <li>
                <router-link
                    class="d-block p-side-15 pt-10 pb-10 trans"
                    to="/signin"
                    >تسجيل دخول</router-link
                >
            </li>
            </template>
            <li v-else>
                <button
                    @click="logout"
                    class="d-block p-side-15 pt-10 pb-10 trans bg-none w-100 border-0"
                >
                    تسجيل خروج
                </button>
            </li>
        </ul>
    </aside>
</template>

<script>
export default {
    emits: ["closeMobileMenu", "logout"],
    props: ['isLoggedIn'],
    methods: {
        closeNavMenu() {
            this.$emit("closeMobileMenu");
        },
        logout() {
            this.$emit("logout");
            this.closeNavMenu()
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
    display:none;
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
        transition: 0.3s;
        right: 0;
        min-height: 100%;
        max-height: 100%;
        overflow-y: auto;
        display:block;
    }
    .close-nav-menu {
        position: absolute;
        top: 20px;
        right: 20px;
    }
}
</style>
