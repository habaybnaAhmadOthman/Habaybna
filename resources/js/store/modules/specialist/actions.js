import { callApi } from "../../common";
export default {
    // ******** get Specialist Name ::: get
    async getSpecialistDetails(context, id) {
        // const resp = await callApi("GET", "/get-user-country");
        const resp = await {
            specialistName: "احمد حمدان",
            speciality: "مختص في علم النفس الإكلينيكي",
            description: "ختصاصي علاج وظيفي أطفال، خريج الجامعة الأردنية، حاصل على العديد من الدورات خاصة في المجالات التالية: التطور النمائي للطفل / مشاكل التكامل الحسي / اللعب / التدخل المبكر، عملت في المنظمات الدولية غير الحكومية والمراكز الخاصة داخل وخارج الأردن، لي خبرة جيدة في مجال دمج أطفال ذوي الإعاقة في المجتمع",
            avatar: 'https://www.blogenium.com/wp-content/uploads/2019/08/blogenium-cute-wallpapers-images-2-1024x576.jpg',
            id: "1"
        };
        // if (resp.status != 200) {
        //     const error = new Error("fail to get course details")
        //     throw error;
        // }
        return resp;
    }
};
