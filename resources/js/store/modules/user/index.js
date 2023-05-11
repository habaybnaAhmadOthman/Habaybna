import getters from './getters'
import actions from './actions'
import mutations from './mutations'
export default {
    namespaced: true,
    state(){
        return {
            phone: null,
            type: null,
            countryCode: 'JO',
            is_verify: false,
            token: null,
            loggedIn: false,
            userID: null,
            avatar: '/images/avatars/default.jpg',
            firstName: null,
            lastName: null,
            openAvatarModal: false,
            canMakeCall: false,
            canMakeComment: false,
            id: null,
            notifications:[]
        }
    },
    mutations,
    actions,
    getters,
}
