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
    async getCourseDetails({_,rootGetters,getters},title) {
        title = title.split('-').join(' ')
        axios.defaults.headers.common.Authorization = `Bearer ${rootGetters['user/userData'].token}`;
        try {
             const resp = getters.courses.filter(course => course.title === title)[0]
             if (!resp)
                getters.courses.filter(course => course.id === title)[0]
             return resp
        } catch (err) {
            const error = new Error("fail to get course");
            throw error;
        }
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
    // ******** Course Lectures ::: get
    async getCourseLectures({_,getters},payload) {
        const resp = await callApi("GET", "/api/course-lectures",payload);
        if (!resp) {
            const error = new Error("something went wrong, please try again");
            throw error;
        }
        return resp.data
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

