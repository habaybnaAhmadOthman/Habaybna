import { callApi } from "../../common";
export default {
    // ******** get Specialists Page (can make calls) ::: get
    async getSpecialistsList(context, payload) {
        const resp = await callApi("GET", `/api/get-calls-providers?page=${payload.page}`);
        if (resp.status != 200) {
            const error = new Error("fail getSpecialistsList ::");
            throw error;
        }
        
        return resp.data;
    },
    // ******** get Specialist Data ::: get
    async getSpecialistDetails(context, id) {
        const resp = await callApi("GET", `/api/get-specialist-data/${id}`);
        if (resp.status != 200) {
            const error = new Error("fail getSpecialistDetails ::");
            throw error;
        }
        
        return resp.data;
    },
    // ******** add appointments ::: POST
    async setAppointments(context,payload) {
        const resp = await callApi("POST", `/api/set-calls-providers-appointments`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to setAppointments");
            throw error;
        }
    },
    
    // ******** get appointments for specialist ::: GET
    async getAppointments(context,payload) {
        const resp = await callApi("GET", `/api/get-specialist-appintments/${payload}`);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to getAppointments");
            throw error;
        }
        return resp.data
    },
    // ******** remove appointments ::: POST
    async removeAppointment(context,payload) {
        const resp = await callApi("POST", `your-api-here`,payload);
        if (!resp || resp.status != 200) {
            const error = new Error("fail to removeAppointment");
            throw error;
        }
    },
};
