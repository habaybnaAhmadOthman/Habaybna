<template>
    <main class="profile">
        <UserProfileHeader></UserProfileHeader>
        <div class="d-flex page-content">
            <UserProfileNav></UserProfileNav>
            <transition name="modal">
                <router-view></router-view>
            </transition>
        </div>
    </main>
</template>

<script>
import Vue from 'vue'
export const userImageModalBus = new Vue();
import UserProfileHeader from "./UserProfile_Header.vue";
import UserProfileNav from "./UserProfile_Nav.vue";
export default {
    components: { UserProfileHeader, UserProfileNav }
};
</script>
<style scoped>
.page-content {
    background: #eef5f9;
}
.modal-enter-active {
    animation: modal 0.3s ease-out;
}

.modal-leave-active {
    animation: modal 0.3s ease-in reverse;
}
@keyframes modal {
    from {
        opacity: 0;
        transform: translateY(50px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>