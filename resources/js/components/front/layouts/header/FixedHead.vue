<template>
    <div>
        <!-- mobile buttons -->
        <div class="mobile-fixed-bar">
            <router-link to="/" class="home-mo mo center mobile-link">
                <img src="/images/home-icon.svg" />
                <p class="font-10 mobile-icon-color">الرئيسية</p>
            </router-link>
            <router-link
                to="/online-courses"
                class="courses-mo mo center mobile-link"
            >
                <img src="/images/mo-video-bottom.svg" width="24" height="21" />
                <p class="font-10 mobile-icon-color">الدورات</p>
            </router-link>
            <div
                class="profile-mo mo center mobile-link"
                @click="openProfileMenu"
            >
                <img src="/images/profile-avatar-mo.svg" />
                <p class="font-10 mobile-icon-color">حسابي</p>
            </div>
            <div class="profile-mo mo center mobile-link">
                <img
                    src="/images/menu-icon-mobile.svg"
                    @click="toggleMobileMenu"
                />
                <p class="font-10 mobile-icon-color">المزيد</p>
            </div>
        </div>
        <LeftSide
            :isMobileMenuOpened="isMobileMenuOpened"
            :toggleMobileMenu="toggleMobileMenu"
            @toggleMobileMenu="toggleMobileMenu"
            :isLoggedIn="isLoggedIn"
        ></LeftSide>
    </div>
</template>

<script>
import LeftSide from "./LeftSide.vue";
export default {
    components: {
        LeftSide,
    },
    data() {
        return {
            isMobileMenuOpened: false,
        };
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters["user/isLoggedIn"];
        },
    },
    methods: {
        toggleMobileMenu() {
            this.isMobileMenuOpened = !this.isMobileMenuOpened;
        },
        openProfileMenu() {
            if (this.isLoggedIn) {
                document.querySelector(".user-side-nav").classList.add("active");
            } else {
                this.$router.push("/signin");
            }
        },
    },
};
</script>

<style scoped>

a {
    position: relative;
}
.mobile-icon-color{
    color: #6E6D6D;
}
.courses-mo {
    filter: brightness(0.4);
}
@media (max-width: 767px) {
    .mobile-link p {
        margin-top: -7px;
    }
    .mobile-fixed-bar {
        position: fixed;
        bottom: 0;
        top: auto;
        padding-left: 12px;
        padding-right: 12px;
        background: #F4F4F4;
        box-shadow: 2px -1px 8px 0px rgb(0 0 0 / 30%);
        right: 0;
        height: 48px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 10;
    }
}
</style>
