import getters from './getters'
import actions from './actions'
import mutations from './mutations'
export default {
    namespaced: true,
    state(){
        return {
            phone: null,
            type: null,
            // token: null,
        }
    },
    mutations,
    actions,
    getters,
}