export default {
    countryCode(state) {
        return state.countryCode;
    },
    type(state) {
        return state.type;
    },
    userData(state) {
        const obj = {
            firstName: state.firstName,
            lastName: state.lastName,
            type: state.type,
            avatar: state.avatar
        }
        console.log(state);
        return state.firstName
    },
    isLoggedIn(state) {
        return !!state.loggedIn;
    }
    // isAuthenticated: state => !!state.user, 
    // user(state,getters,rootState,rootGetters)
};
