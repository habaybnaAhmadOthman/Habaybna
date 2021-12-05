import Vue from "vue";
import vuex from "vuex"; 
import UserModule from "./modules/user/index.js";
import getters from "./getters";
import mutations from "./mutations";

import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";
const ls = new SecureLS({isCompression: false});
Vue.use(vuex);

const store = new vuex.Store({
    modules: {
        user: UserModule
    },
    state() {
        return {};
    },
    getters,
    mutations,
    plugins: [
        createPersistedState({
            key: "user",
            path: ["user"],
            storage: {
                getItem: key => ls.get(key),
                setItem: (key, value) => ls.set(key,value),
                removeItem: key => ls.remove(key)
            }
        })
    ]
});
export default store;
