export default {
    setUser(state, payload) {
        console.log('payload',payload);
        if (payload.firstName)
            state.firstName = payload.firstName;
        if (payload.lastName)
            state.lastName = payload.lastName;
        if (payload.type)
            state.type = payload.type;
        if (payload.avatar)
            state.avatar = payload.avatar;
        if (payload.token)
            state.token = payload.token;
        if (payload.notifications)
            state.notifications = payload.notifications;
        if (payload.id)
            state.id = payload.id;
        if (payload.canMakeCalls || !payload.canMakeCalls)
            state.canMakeCalls = payload.canMakeCalls;
        if (payload.canMakeComment || !payload.canMakeComment)
            state.canMakeComment = payload.canMakeComment;
        if (!state.avatar || state.avatar == 'default.jpg')
            state.avatar = '/images/avatars/default.jpg';
        state.loggedIn = true;
        state.is_verify = true;
    },
    clearUser(state) {
        state.firstName = null;
        state.canMakeCalls = null;
        state.canMakeComment = null
        state.lastName = null;
        state.type = null;
        state.avatar = null;
        state.token = null;
        state.loggedIn = false;
        state.is_verify = false;
        state.id = null;
    },
    clearAdmin(state) {
        state.firstName = null;
        state.lastName = null;
        state.type = null;
        state.avatar = null;
        state.token = null;
        state.loggedIn = false;
        state.is_verify = false;
        state.id = null;


    },
    type(state, userType) {
        state.type = userType;
    },
    openAvatarModal(state, isOpen) {
        state.openAvatarModal = isOpen;
    },
    login(state) {
        state.loggedIn = true;
        state.is_verify = true;
    },
    userAvatar(state, src) {
        state.avatar = src
    },
    setCountryCode(state, countryCode) {
        state.countryCode = countryCode || state.countryCode;
    },
    // userNotifications(state){

    // }
    // login(state,payload){
    //     state.is_verify = payload.is_verify;
    // },
};
