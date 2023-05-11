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
    avatar(state) {
        return state.avatar;
    },
    userData(state) {
        const obj = {
            firstName: state.firstName,
            lastName: state.lastName,
            type: state.type,
            token: state.token,
            avatar: state.avatar,
            canMakeCalls: state.canMakeCalls,
            canMakeComment: state.canMakeComment,
            id:state.id,
            notifications:state.notifications
        }
        return obj
    },
    checkToken(state) {
        return state.token;
    },
    isLoggedIn(state) {
        return !!state.loggedIn;
    },
    notifications(state) {

       const  notification = {
           notifications: state.notifications,
           count: state.notifications.length,
        }
        return notification
    }


    // isAuthenticated: state => !!state.user,
    // user(state,getters,rootState,rootGetters)
};
