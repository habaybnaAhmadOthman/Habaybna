<template>
    <main>
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
.content-inner {
    position: relative;
    width: calc(100% - 250px);
    min-height: calc(100vh - 65px);
    padding-bottom: 60px;
    background: #eef5f9;
}
.page-header {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 10%);
}
h1 {
    color: #2f333e;
    font-size: 18px;
    font-weight: bold;
}
.card {
    box-shadow: 2px 2px 2px rgb(0 0 0 / 10%), -1px 0 2px rgb(0 0 0 / 5%);
    background: #fff;
}
.form-group {
    margin-bottom: 25px;
}
.form-control-label {
    font-size: 0.9rem;
    color: #660066;
    margin-bottom: 10px;
    display:block;
}
.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.col-md-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}
.col-md-4, .col-md-3 {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
.col-md-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
}
.form-control::placeholder {
    color:#aaa;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 14px;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.form-control {
    height: calc(2.25rem + 2px);
    border: 1px solid #dee2e6;
    border-radius: 0;
    padding: 0.375rem 0.75rem;
}
button,
input {
    outline: none !important;
}
.card-body {
    padding: 1.25rem;
}
</style>
