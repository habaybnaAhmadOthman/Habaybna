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
        let categories = [];
        let courseID = getters.course.id;
        getters.course.categories.map((e,i) => {
            categories.push(  e.id)
        })
        let RelatedCourses = []
        RelatedCourses = shuffledCourses.filter(course => {
            if (course.id != courseID)
                return course.categories.filter(category=>categories.includes(category.id))
        })
        return RelatedCourses.slice(0,6);
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
    async getCourseDetails({_,rootGetters,getters,commit,dispatch},title) {
        try {
            var coursesFromAPI = getters.courses;
            if (coursesFromAPI.length == 0) {
                coursesFromAPI = await dispatch('getAllCourses')
            }
            title = title.split('-').join(' ')
            axios.defaults.headers.common.Authorization = `Bearer ${rootGetters['user/userData'].token}`;
            let resp = coursesFromAPI.find(course => course.title == title)
            if (!resp)
                resp = coursesFromAPI.find(course => course.id == +title)
            
            commit('setCourse',resp);
            return resp
        } catch (err) {
            const error = new Error("fail to get course");
            throw error;
        }
    },
    // ******** Course Lectures ::: get
    async getCourseLectures({commit,getters},payload) {
        const resp = await callApi("POST", "/api/course/course-lectures",payload);
        if (!resp) {
            const error = new Error("something went wrong, please try again");
            throw error;
        }
        commit('courseLectures',resp.data)
        return resp.data
    },
    // ******** Buy Course ::: post
    async buyCourse({_,getters},payload) {
        const resp = await callApi("POST", "/api/course-payment",payload);
        if (!resp) {
            const error = new Error("something went wrong, please try again");
            throw error;
        }
        return resp.data[0]
    },
    // ******** PromoCode ::: post
    async promoCode({_,getters},payload) {
        const resp = await callApi("POST", "/api/check-promocode",payload);
        if (!resp.data.isValid) {
            const error = new Error("fail.");
            throw error;
        }
        return resp.data
    },
};

