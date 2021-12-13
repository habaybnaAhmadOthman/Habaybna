export default {
    countryCode(state) {
        return state.countryCode;
    },
    type(state) {
        return state.type;
    },
    openAvatarModal(state) {
        return state.openAvatarModal;
    },
    userData(state) {
        const obj = {
            firstName: state.firstName,
            lastName: state.lastName,
            type: state.type,
            token: state.token,
            avatar: state.avatar
        }
        return obj
    },
    checkToken(state) {
        return state.token;
    },
    isLoggedIn(state) {
        return !!state.loggedIn;
    }
    // isAuthenticated: state => !!state.user, 
    // user(state,getters,rootState,rootGetters)
};
