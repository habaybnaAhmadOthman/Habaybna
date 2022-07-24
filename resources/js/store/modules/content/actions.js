import { callApi } from "../../common";
export default {
    // ******** get Contents ::: get
    async getContent(context,payload) {
        let queryFilters = `?page=${payload.page}`
        if (payload.filters && payload.filters.length > 0)
            queryFilters += `&filters=${payload.filters}`
        const resp = await callApi("GET", `/api/get-contents-new${queryFilters}`);
        if (resp.status != 200) {
            const error = new Error("fail to get contents");
            throw error;
        }
        return resp.data;
    },
    // ******** get Article By Name ::: POST
    async getArticle(context,payload) {
        const resp = await callApi("POST", `/api/show-article`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to get article");
            throw error;
        }
        return resp.data;
    },
    // ******** get liked Articles ::: GET
    async getLikedArticles(context,payload) {
        const resp = await callApi("GET", `/api/user/likes-articles?page=${payload.page}`);
        if (resp.status != 200) {
            const error = new Error("fail to get liked articles");
            throw error;
        }
        return resp.data;
    },
    // ******** Favourite actions  ::: post
    async addToFavourite({commit,getters},payload) {
        const resp = await callApi("POST", "/api/article/add-to-fav",payload);
        if (resp.status != 200) {
            const error = new Error("can't add to favourites");
            throw error;
        }
        console.log(resp)
        // const targetedCourseIndex = getters.courses.findIndex(course => course.id == payload.courseID);
        // const targetedCourse = getters.courses[targetedCourseIndex]
        // targetedCourse.is_favourite = !targetedCourse.is_favourite
        // getters.courses[targetedCourseIndex] = targetedCourse
        
        // commit('setAllCourses',getters.courses)
    },
    // ******** Contact US ::: POST
    async contactUS(context,payload) {
        const resp = await callApi("POST", `/api/contact-us`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to contact us");
            throw error;
        }
    },
    // ******** Media ::: GET
    async getMedia(context) {
        const resp = await callApi("GET", `/api/media`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to get media");
            throw error;
        }
        return resp.data
    },
    // ******** Partners ::: GET
    async getPartners(context) {
        const resp = await callApi("GET", `/api/parteners`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to get media");
            throw error;
        }
        return resp.data
    },
    // ******** Testimonial ::: GET
    async getTestimonials(context,payload) {
        const resp = await callApi("GET", `/api/get-testimonials/${payload.type}`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to get Testimonials");
            throw error;
        }
        return resp.data
    },
};
