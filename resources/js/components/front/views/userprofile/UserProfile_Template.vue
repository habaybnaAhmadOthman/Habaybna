<template>
    <main class="profile">
        <UserProfileHeader></UserProfileHeader>
        <div class="d-flex page-content">
            <UserProfileNav></UserProfileNav>
            <div class="content-inner">
                <div class="page-header bg-white relative">
                    <div class="container-fluid pt-15 pb-15">
                        <slot name="page-header">
                            <h1>الحساب الشخصي</h1>
                        </slot>
                    </div>
                </div>
                <div class="content-container">
                    <slot></slot>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import UserProfileHeader from "./UserProfile_Header.vue";
import UserProfileNav from "./UserProfile_Nav.vue";
export default {
    components: { UserProfileHeader, UserProfileNav }
};
</script>
<style scoped>
.container-fluid {
    min-width: auto!important;
}
.content-inner {
    position: relative;
    width: calc(100% - 230px);
    min-height: calc(100vh - 65px);
    padding-bottom: 60px;
    background: #eef5f9;
}
.page-header {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 10%);
}
.card {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 10%), -1px 0 2px rgb(0 0 0 / 5%);
    background: #fff;
}
h1 {
    color: #2f333e;
    font-size: 18px;
    font-weight: bold;
}
</style>