import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
export default {
    namespaced: true,
    state() {
        return {
            categories: [],
            courses: [],
            course: null,
            courseLectures: [],
            currentLecture: null,
            myCourses: [],
        };
    },
    mutations,
    actions,
    getters
};
