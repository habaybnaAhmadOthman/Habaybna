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
};
