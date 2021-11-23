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
    loggedIn(state) {
        return state.is_verify;
    }
    // user(state,getters,rootState,rootGetters)
};
