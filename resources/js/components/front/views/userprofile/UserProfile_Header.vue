<template>
    <header class="user-header">
        <nav class="user-nav pt-10 pb-10">
            <div class="container-fluid">
                <div class="d-flex space-between align-center">
                    <div class="d-flex align-center">
                        <!-- <div class="user-avatar-box overflow-hidden radius-60 relative d-flex" @click="openUserImageModal"> -->
                        <div class="user-avatar-box overflow-hidden radius-60 relative d-flex" :class="{'cant-edit-img': !canEditImage}" @[mayclick]="openUserImageModal">
                            <img
                                :src="avatar"
                                width="45"
                                height="45"
                                class="pointer user-avatar user-avatar-get radius-60 object-fit"
                            />
                        </div>
                        <div class="user-info-card mr-10 white">
                            <p class="font-14">{{firstName + ' ' + lastName}}</p>
                        </div>
                        <!-- <div class="white font-10 mr-15">
                            Notifications Here
                        </div> -->
                    </div>
                    <div class="do">
                        <div class="d-flex align-center">
                            <router-link class="white-i ml-20" to="/">عودة الى الرئيسية</router-link>
                            <button class="p-10 radius-5 bg-none white pointer btn-logout" @click="logout">تسجيل خروج</button>
                        </div>
                    </div>
                    <!-- <span class="open-nav-menu mo white font-30" @click="openNavMenu">☰</span> -->
                    
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    data() {
        return {
            isMenuOpened: false,
            canEditImage: false,
            firstName: '',
            lastName: '',
            avatar: ''
        }
    },
    async created() {
        if (this.$route.name == 'myAccount') {
            this.canEditImage = true
        }
        const obj = await this.$store.getters['user/userData'];
        this.firstName = obj.firstName
        this.lastName = obj.lastName
        this.avatar = obj.avatar  
    },
    computed: {
        mayclick: function() {
            return this.canEditImage ? "click" : null;
        }
    },
    methods: { 
        openNavMenu(){
            document.querySelector('.user-side-nav').classList.add('active')
        },
        openUserImageModal(){
            this.$store.commit('user/openAvatarModal',true);
        },
        logout(){
            this.$store.dispatch('user/logout');
            this.$router.push("/");
        }
    },
    watch:{
        $route (to, from){
            if (to.name == 'myAccount') {
                this.canEditImage = true
            } else {
                this.canEditImage = false
            }
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
.user-avatar-box:not(.cant-edit-img):after {
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
