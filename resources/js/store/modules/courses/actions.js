import {callApi, shuffle} from "../../common";
export default {
    // ******** get all courses ::: get
    async getAllCourses(context) {
        const resp = await callApi("GET", "/api/all-courses");
        if (resp.status != 200) {
            const error = new Error("fail to get courses");
            throw error;
        }
        context.commit('setAllCourses',resp.data.courses)
        return resp.data.courses;
    },
    // ******** get all courses ::: get
    async getRelatedCourses({_,getters},courseCategories) {
        let shuffledCourses = await shuffle(getters.courses);
        // shuffledCourses.filter(course =>{
        //     if ()
        // })
        return shuffledCourses;
    },
    // ******** get all categories ::: get
    async getCategories() {
        const resp = await callApi("GET", "/api/get-categories");
        if (!resp || resp.status != 200) {
            const error = new Error("fail to get courses");
            throw error;
        }
        return resp.data;
    },
    async getCourseDetails({_,getters},title) {
        title = title.split('-').join(' ')
        try {
             const resp = getters.courses.filter(course => course.title === title)[0]
             return resp
        } catch (err) {
            const error = new Error("fail to get course");
            throw error;
        }
    },
    // ******** course PAYMENT ::: post
    async buyCourse({_,getters},payload) {
        const resp = await callApi("POST", "/course-payment",payload.courseID);
        if (!resp || resp.status != 200) {
            const error = new Error("please try again");
            throw error;
        }
        return resp.data;
    },
};

