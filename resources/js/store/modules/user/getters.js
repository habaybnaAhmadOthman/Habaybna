export default {
    user(state) {
        return state.user;
    },
    countryCode(state) {
        return state.countryCode;
    },
    type(state) {
        return state.type;
    },
    isLoggedIn(state) {
        return Boolean(state.loggedIn);
    }
    // user(state,getters,rootState,rootGetters)
};
