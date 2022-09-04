<template>
    <aside class="user-side-nav bg-white z-1">
        <div class="z-1">
            <img
                src="/images/close-icon-color.png"
                width="30"
                height="30"
                @click="closeNavMenu"
                class="close-nav-menu mo"
            />
            
            <ul class="user-side-nav-list">
                <li v-if="isLoggedIn" class="center">
                    <img
                        :src="userAvatar"
                        width="70"
                        height="70"
                        class="user-avatar rounded object-fit"
                    />
                </li>
                <li>
                    <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/" @click.native="closeNavMenu"
                        >الصفحة الرئيسية</router-link
                    >
                </li>
                <li>
                    <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/online-courses" @click.native="closeNavMenu"
                        > الدورات التدريبية</router-link
                    >
                </li>
                <li>
                    <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/ask-specialists" @click.native="closeNavMenu"
                        > الاستشارات مع المختصين</router-link
                    >
                </li>
                <li>
                    <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/library" @click.native="closeNavMenu"
                        >مكتبة المعلومات</router-link
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
                        >مستخدم جديد</router-link
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
                        class="d-block p-side-15 pt-10 pb-10 trans bg-none w-100 border-0 logout-btn"
                    >
                        تسجيل خروج
                    </button>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script>
export default {
    emits: ["closeMobileMenu", "logout"],
    props: ['isLoggedIn', 'userAvatar'],
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
.user-side-nav li > *:not(img) {
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
        min-width: 85%;
        max-width: none;
        top: 0;
        transition: 0.3s;
        left: 0;
        min-height: 100%;
        max-height: 100%;
        overflow-y: auto;
        display:block;
        z-index: 11;
    }
    .close-nav-menu {
        position: absolute;
        top: 20px;
        right: 20px;
    }
    .user-avatar {
        border: 2px solid #660066;
    }
    .logout-btn {
        text-align: right;
        color: #3FC4E0!important;
        background: transparent!important;
    }
    .user-side-nav:before {
        content: '';
        position: fixed;
        right: 0;
        top: 0;
        width: 15%;
        height: 100%;
        z-index: 0;
        backdrop-filter: brightness(.9) blur(2px);
        -webkit-backdrop-filter: brightness(.9) blur(2px);
    }
}
</style>
