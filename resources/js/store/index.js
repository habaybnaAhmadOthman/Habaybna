import Vue from "vue";
import vuex from "vuex";
import UserModule from "./modules/user/index.js";
import getters from "./getters";
import mutations from "./mutations";
Vue.use(vuex);

const store = new vuex.Store({
    modules: {
        user: UserModule
    },
    state() {
        return {
            
        };
    },
    getters,
    mutations
});
export default store;
