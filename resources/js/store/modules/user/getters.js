export default {
    userID(state) {
        return state.userID;
    },
    countryCode(state) {
        return state.countryCode;
    },
    type(state) {
        return state.type;
    },
    isLoggedIn(state) {
        return !!state.loggedIn;
    }
    // user(state,getters,rootState,rootGetters)
};
