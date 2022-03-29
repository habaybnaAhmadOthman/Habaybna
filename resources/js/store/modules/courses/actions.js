import {callApi, shuffle} from "../../common";
function isPurchased(course){
    return course.course_progress.length != 0
}
function allCourses(restCourses,myCourses){
    return [...restCourses,...myCourses]
}
export default {
    // ******** get all courses ::: get
    async getAllCourses({_,rootGetters,getters,commit,dispatch}) {
        const resp = await callApi("GET", "/api/all-courses");
        if (resp.status != 200) {
            const error = new Error("fail getAllCourses ::");
            throw error;
        }
        let allCourses = resp.data.courses;
        let myCoursesIDs = resp.data.my_courses;
        let myCourses = []
        let restCourses = []
        for (let i =0; i < allCourses.length; i++) {
            if (myCoursesIDs.includes(allCourses[i].id)) { // it's my course
                myCourses.push({...allCourses[i],isPurchased:true})
            } else {
                restCourses.push({...allCourses[i],isPurchased:false})
            }
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
    async videoAction({commit},payload) {

        const resp = await callApi("POST", "/api/course/video-actions",payload);
        if (resp.status != 200) {
            const error = new Error("fail to take action");
            throw error;
        }
        commit('completeLecture',payload)
        return resp.data
    },
    // ******** Favourite actions  ::: post
    async addToFavourite({commit},payload) {
        const resp = await callApi("POST", "/api/course/add-to-fav",payload);
        if (resp.status != 200) {
            const error = new Error("fail to take action");
            throw error;
        }
        return resp.data
    },
    // ******** get user courses ::: get
    async getMyCourses({_,rootGetters,getters,commit,dispatch}) {
        try {
            var myCourses = getters.myCourses;
            if (myCourses.length == 0) {
                await dispatch('getAllCourses')
            }
            return getters.myCourses
        } catch (err) {
            const error = new Error("fail getMyCourses ::",err);
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
            // if (rootGetters['user/isLoggedIn']) {
            //     coursesFromAPI = getters.myCourses;
            // } else
            //     coursesFromAPI = getters.courses;

            if (coursesFromAPI.length == 0) {
                await dispatch('getAllCourses')
            }

            coursesFromAPI = allCourses(getters.courses,getters.myCourses)
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
        // to check if the user still in the same course
        console.log(getters.courseLectures)
        if ((payload.courseID == getters.course.id) &&
            getters.courseLectures.length != 0 && getters.courseLectures[0].title == getters.course.videos_title_length[0].lesson_title) {
                return getters.courseLectures
        }

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
    // ******** Take Free Course ::: post
    async getFreeCourse({_,getters},payload) {
        const resp = await callApi("POST", "/api/courses/free-course",payload);
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

