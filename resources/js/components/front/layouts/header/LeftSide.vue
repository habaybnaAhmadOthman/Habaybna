<template>
    <div class="left-side d-flex align-center">
        <router-link to="" class="white-i d-flex radius-60 free-call-btn ml-10">
            <img
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAXCAYAAAARIY8tAAAABHNCSVQICAgIfAhkiAAAAUVJREFUSEvtletNw0AQhL+pAOggqQA6IHQAFRAqgFQAqQA6gA6ACog7oAPcAVDBorHuosNK/BCCP2Sl00m+8c7srM8rNkREzIBL4BR4BRaSViU0Iq4SZgI8JUzdTqf2g4jYB96AT+AhkRwCJ5kkIubAPfCcBJjsXdJ0CIHBt8BUUp0IrX7PCQoBlSRXSER4fyxFZKJNFdwA18CBpI+UwJa9ABeALfF5I6B1vq6yi8AJbJFVnxUkTuZ+HHkv1Btv9bZnkvFbCZIie3zn6tNur12Zk7kfyyTgHDDW/ZpJsoBvoYhwIw38jViYwCqHRJVUG+ueHA94qRpDsJRkm/zV5A+hj+NvCFyuV1+sios2/J2+rD89by7aQE/H9qC5dDuCrhbtLGp+2f/Iojzyukoee9GaibcemRHhSeWBvy3qYkR68Hj1Yr8A4IPu+TfvWYgAAAAASUVORK5CYII="
                alt="gift"
                class="ml-20"
            />إهداء مكالمة مجانیة</router-link
        >
        <div class="do" v-if="isLoggedIn">
            <div class="d-flex align-center">
                <img
                    :src="userAvatar"
                    alt="gift"
                    class="rounded object-fit ml-20 user-avatar"
                />
                <p class="white">{{ userName }}</p>
            </div>
        </div>
        <div class="bar"></div>
        <template v-if="!isLoggedIn">
            <router-link
                to="/signup"
                class="signin-box-btn pr-30 relative bold white"
                >تسجيل</router-link
            >
            <router-link
                to="/signin"
                class="signin-box-btn pr-30 relative bold white"
                >تسجيل الدخول</router-link
            >
        </template>
        <template v-else>
            <button
                @click="logout"
                
                class="sign-out-box bg-none border-0 pointer pr-30 relative bold white do"
            >
                تسجيل الخروج
            </button>
        </template>
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAXCAYAAAARIY8tAAAABHNCSVQICAgIfAhkiAAAAUVJREFUSEvtletNw0AQhL+pAOggqQA6IHQAFRAqgFQAqQA6gA6ACog7oAPcAVDBorHuosNK/BCCP2Sl00m+8c7srM8rNkREzIBL4BR4BRaSViU0Iq4SZgI8JUzdTqf2g4jYB96AT+AhkRwCJ5kkIubAPfCcBJjsXdJ0CIHBt8BUUp0IrX7PCQoBlSRXSER4fyxFZKJNFdwA18CBpI+UwJa9ABeALfF5I6B1vq6yi8AJbJFVnxUkTuZ+HHkv1Btv9bZnkvFbCZIie3zn6tNur12Zk7kfyyTgHDDW/ZpJsoBvoYhwIw38jViYwCqHRJVUG+ueHA94qRpDsJRkm/zV5A+hj+NvCFyuV1+sios2/J2+rD89by7aQE/H9qC5dDuCrhbtLGp+2f/Iojzyukoee9GaibcemRHhSeWBvy3qYkR68Hj1Yr8A4IPu+TfvWYgAAAAASUVORK5CYII="
            class="mo"
            @click="toggleMobileMenu">
            <transition name="swing">
                <MobileMenu :isLoggedIn="isLoggedIn" @closeMobileMenu="toggleMobileMenu" @logout="logout" v-if="isMobileMenuOpened"></MobileMenu>
            </transition>
    </div>
</template>

<script>
import MobileMenu from "./MobileMenu.vue"
export default {
    props: ["isLoggedIn"],
    components: {MobileMenu},
    data(){
        return {
            isMobileMenuOpened: false
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch("user/logout");
            if (this.$router.currentRoute.name != "home") {
                this.$router.push("/");
            }
        },
        toggleMobileMenu(){
            this.isMobileMenuOpened = !this.isMobileMenuOpened
        }
    },
    computed: {
        userAvatar() {
            return this.$store.getters["user/userData"].avatar;
        },
        userName() {
            const user = this.$store.getters["user/userData"];
            return user.firstName + " " + user.lastName;
        }
    }
};
</script>

<style scoped>
.bar {
    width: 1px;
    border: 0.9px solid #fff;
    height: 35px;
    margin: 0 22px;
}
.sign-out-box:before {
    content: "";
    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAARCAYAAADdRIy+AAAABHNCSVQICAgIfAhkiAAAALpJREFUOE/NlO0NAVEQRc/tQAd0QAeoAB2sDqgAHemAEuhACVQw8mQ2sRvvY5MN3t+5OXMzd+aJxDOzMzBNaVq1g74NrIBRgcOda9IOC0AviZnZb4FmNgMWkrafXHd26MATcAFWkm7v4AbQV6OeQWxsA2DixTuwlnSsxW1gDhZrMpcU9rQZijvMBRocjl30AKqowxzJHYRQwgyvwDI5ww7AANr0knKuaee16Q1oZuGWhzkgsC86vb/4vp6vInJf5SsvrwAAAABJRU5ErkJggg==)
        no-repeat;
    position: absolute;
    width: 20px;
    height: 17px;
    right: 0;
    top: 3px;
}
.free-call-btn {
    background: #606;
    padding: 10px 15px;
}
.user-avatar {
    width: 50px;
    height: 50px;
}
.swing-enter-active {
    animation: swing 0.3s ease-out;
}

.swing-leave-active {
    animation: swing 0.3s ease-in reverse;
}
@keyframes swing {
    from {
        right:-100%;
        opacity:0;
    }

    to {
        right:0;
        opacity:1;
    }
}
@media (max-width: 1200px) {
    .free-call-btn {
        display: none;
    }
}
</style>
