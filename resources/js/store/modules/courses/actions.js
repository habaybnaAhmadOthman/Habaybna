import {callApi, shuffle} from "../../common";
export default {
    // ******** get all courses ::: get
    async getAllCourses({_,rootGetters,getters,commit,dispatch}) {

        const resp = await callApi("GET", "/api/all-courses");
        if (resp.status != 200) {
            const error = new Error("fail to get courses");
            throw error;
        }
        // const myCourses = resp.data.courses.filter(course=>course.course_progress !== null);
        let myCourses = [];
        let restCourses = [];
        if (rootGetters['user/isLoggedIn']) {
            for (let i =0; i < resp.data.courses.length; i++) {
                if (resp.data.courses[i].course_progress !== null) { // it's my course
                    myCourses.push(resp.data.courses[i])
                } else {
                    restCourses.push(resp.data.courses[i])
                }
            }
        } else {
            restCourses = resp.data.courses
        }
        
        commit('setMyCourses',myCourses)
        commit('setAllCourses',restCourses)
        return restCourses;
    },

    // ******** get lesson progress ::: get
    async getLectureProgress({getters},payload) {
        console.log(getters.course) 
    },
    // ******** get lesson data  ::: get
    async videoAction(context,payload) {
        
        const resp = await callApi("POST", "/api/course/video-actions",payload);
        if (resp.status != 200) {
            const error = new Error("fail to take action");
            throw error;
        }
    },
    // ******** get user courses ::: get
    async getMyCourses({_,rootGetters,getters,commit,dispatch}) {
        try {
            var myCourses = getters.myCourses;
            if (myCourses.length == 0) {
                await dispatch('getAllCourses')
            }
            
            // const resp = await callApi("GET", "/api/courses/get-user-courses");
            // if (resp.status != 200) {
            //     const error = new Error("fail to get my courses");
            //     throw error;
            // }
            // console.log(coursesFromAPI);
            // let myCourses = coursesFromAPI.filter(course => resp.data.includes(course.id))
            return getters.myCourses
        } catch (err) {
            const error = new Error("fail to get course");
            throw error;
        }
    },
    // ******** get related courses ::: get
    async getRelatedCourses({_,getters},courseCategories) {
        let shuffledCourses = await shuffle(getters.courses);
        let categories = [];
        let courseID = getters.course.id;
        getters.course.categories.map((e,i) => {
            categories.push(  e.id)
        })
        let RelatedCourses = []
        RelatedCourses = shuffledCourses.filter(course => {
            if (course.id != courseID ) {
                let hasRelatedCategories =  course.categories.filter(category=>{
                    return categories.includes(category.id)
                })
                if (hasRelatedCategories.length > 0) return course;
                
            }
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
            const error = new Error("fail getCourseDetails ::",err);
            throw error;
        }
    },
    async getMyCourseData({_,rootGetters,getters,commit,dispatch},title) {
        try {
            
            var myCourses = getters.myCourses;
            if (myCourses.length == 0) {
                myCourses = await dispatch('getMyCourses')
            }
            title = title.split('-').join(' ')
            axios.defaults.headers.common.Authorization = `Bearer ${rootGetters['user/userData'].token}`;
            let resp = myCourses.find(course => course.title == title)
            if (!resp)
                resp = myCourses.find(course => course.id == +title)

            commit('setCourse',resp);
            return resp
        } catch (err) {
            const error = new Error("fail getMyCourseData ::",err);
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

