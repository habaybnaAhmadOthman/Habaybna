import { callApi } from "../../common";
export default {
    // ******** get Contents ::: get
    async getContent(context) {
        const resp = await callApi("GET", "/api/contents?page=2");
        if (resp.status != 200) {
            const error = new Error("fail to get contents");
            throw error;
        }
        return resp.data;
    },
};
