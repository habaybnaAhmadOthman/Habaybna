import Vue from "vue";
import vuex from "vuex";
import UserModule from "./modules/user/index.js";
Vue.use(vuex);

const store = new vuex.Store({
    modules: {
        user: UserModule
    },
    state() {
        return {};
    },
    getters: {
        getTest() {}
    }
});
export default store;
