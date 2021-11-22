export default {
    setUser(state,payload){
        state.phone = payload.phone
        state.type = payload.type
        state.token = payload.token
    },
    // parentCompleteRegistration(state,payload){
    //     state.phone = payload.phone
    //     state.type = payload.type
    //     console.log(state);
    // },
}