import {callApi} from "../../common";
export default {
    // ******** get all courses ::: get
    async getCourses(context) {
        const resp = await callApi("GET", "/get-user-country");
        if (resp.status != 200) {
            const error = new Error("fail to get courses");
            throw error;
        }
        const countryCode = resp.data.data.countryCode
        context.commit('setCountryCode',countryCode)
    },
    // ******** get all categories ::: get
    async getCategories(context) {
        const resp = await callApi("GET", "/get-categories");
        if (resp.status != 200) {
            const error = new Error("fail to get categories");
            throw error;
        }
        const countryCode = resp.data.data.countryCode
        context.commit('setCountryCode',countryCode)
    },
    async getCourseDetails(context,courseID) {
        // const resp = await callApi("GET", "/api/get-course-details",courseID);
        const resp = await {
            "courseName": "Bessie Hamill",
            "trailerSrc": "trailerSrc 1",
            "specialistName": "coachName 1",
            "courseDescription": "courseDescription 1",
            "lectures": [
             {
              "title": "الخطة التربوية",
              "time": "12"
             },
             {
              "title": "العمل التطوعي",
              "time": "2"
             },
             {
              "title": "العمل",
              "time": "22"
             },
             {
              "title": "التطوعي",
              "time": "12"
             },
             {
              "title": "السباحة المنيحة",
              "time": "23"
             },
             {
              "title": "السباحة",
              "time": "43"
             },
             {
              "title": "المنيحة",
              "time": "25"
             }
            ],
            "id": "1"
           }
        // if (resp.status != 200) {
        //     const error = new Error("fail to get course details")
        //     throw error;
        // }
        return resp;
    }
};
