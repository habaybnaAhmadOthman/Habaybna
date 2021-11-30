<template>
    <header class="user-header">
        <nav class="user-nav pt-10 pb-10">
            <div class="container-fluid">
                <div class="d-flex space-between align-center">
                    <div class="d-flex align-center">
                        <div class="user-avatar-box overflow-hidden radius-60 relative d-flex" @click="openUserImageModal">
                            <img
                                src="/images/siteImgs/header/logo.png"
                                width="45"
                                height="45"
                                class="pointer user-avatar radius-60 object-fit"
                            />
                        </div>
                        <div class="white font-10 mr-15">
                            Notifications Here
                        </div>
                    </div>
                    <div class="do">
                        <div class="d-flex align-center">
                            <router-link class="white-i ml-20" to="/">عودة الى الرئيسية</router-link>
                            <button class="p-10 radius-5 bg-none white pointer btn-logout" @click="logout">تسجيل خروج</button>
                        </div>
                    </div>
                    <img
                        src="/images/siteImgs/header/logo.png"
                        width="20"
                        height="20"
                        @click="openNavMenu"
                        class="open-nav-menu mo"
                    />
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import {userImageModalBus} from './../../views/userprofile/UserProfile_Template.vue'
export default {
    data() {
        return {
            isMenuOpened: false
        }
    },
    methods: { 
        openNavMenu(){
            document.querySelector('.user-side-nav').classList.add('active')
            document.querySelector("body").classList.add("overflow-hidden");
        },
        openUserImageModal(){
            userImageModalBus.$emit('openImageModal')
        },
        logout(){
            this.$store.dispatch('user/logout');
            this.$router.push("/");
        }
    }
}
</script>

<style scoped>
/* header */
.user-header {
    background: #660066;
}
.user-nav {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 20%);
}
.user-avatar {
    border: 1px solid #fff;
}
.user-avatar-box:after {
    content: '';
    background: #000;
    position: absolute;
    left: 0;
    top :0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    opacity:0;
    transition: .3s;
}
.user-avatar-box:hover:after {
    opacity:0.5;
}
.btn-logout {
    border: 1px solid #fff;
}
/* end header */
</style>
