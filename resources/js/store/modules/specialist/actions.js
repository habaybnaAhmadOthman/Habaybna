import { callApi } from "../../common";
export default {
    // ******** get Specialist Data ::: get
    async getSpecialistDetails(context, id) {
        const resp = await callApi("GET", `/api/get-specialist-data/${id}`);
        if (resp.status != 200) {
            const error = new Error("fail getSpecialistDetails ::");
            throw error;
        }
        
        return resp.data;
    }
};
