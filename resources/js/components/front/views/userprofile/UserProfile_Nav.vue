<template>
    <aside class="user-side-nav bg-white z-1">
        <ul class="pt-30">
            <li class="active">
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/">حسابي</router-link>
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/">حساب الطفل</router-link>
            </li>
            <li>
                <router-link class="d-block p-side-15 pt-10 pb-10 trans" to="/">الإستشارات</router-link>
            </li>
        </ul>
    </aside>
</template>

<style scoped>
.user-side-nav {
    min-width: 230px;
    max-width: 230px;
    color: #686a76;
    box-shadow: -1px 1px 1px rgb(0 0 0 / 10%);
    min-height: calc(100vh - 65px);
}
.user-side-nav li > a {
    border-right: 4px solid transparent;
    color:#212529;
}
.user-side-nav li.active > a, .user-side-nav li:hover > a {
    background: #660066;
    color: #fff;
    border-color: #b915b9;
}
</style>
