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
    }
};
