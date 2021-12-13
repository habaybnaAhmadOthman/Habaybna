import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
export default {
    namespaced: true,
    state() {
        return {
            categories: [
                {
                    id: "v1",
                    title: "المساق الرقمي"
                },
                {
                    id: "v2",
                    title: "مشاريع"
                },
                {
                    id: "v3",
                    title: "محاسبة"
                },
                {
                    id: "v4",
                    title: "أرقام"
                },
                {
                    id: "v5",
                    title: "كمبيوتر"
                },
                {
                    id: "v6",
                    title: "معلومات"
                },
                {
                    id: "v7",
                    title: "فراسة"
                }
            ],
            courses: []
        };
    },
    mutations,
    actions,
    getters
};

// {
//     id: 1,
//     title: "المساق الرقمي | مشاريع مستدامة من أجل الحياة",
//     category: ["v1", "v4"],
//     description:
//         "في هذا الجزء من المساق سيتم استعراض أهم الأسس في مجال اختبارات الذكاء عند تصميم الخطة التربوية الفردية للأطفال ذوي الاضطرابات النمائية",
//     videos: "12",
//     hours: "3",
//     discount: "50",
//     beforeDiscount: "100",
//     price: "50",
//     provider: "حبايبنا نت",
//     coverImage: 'https://png.pngtree.com/thumb_back/fh260/background/20200714/pngtree-modern-double-color-futuristic-neon-background-image_351866.jpg'
// },