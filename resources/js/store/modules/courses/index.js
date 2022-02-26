import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
export default {
    namespaced: true,
    state() {
        return {
            categories: [],
            courses: [],
            // courseID: null,
            course: null
        };
    },
    mutations,
    actions,
    getters
};
