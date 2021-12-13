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
            courses: [
                {
                    id: 1,
                    title: "المساق الرقمي | مشاريع مستدامة من أجل الحياة",
                    category: ["v1", "v4"],
                    description:
                        "في هذا الجزء من المساق سيتم استعراض أهم الأسس في مجال اختبارات الذكاء عند تصميم الخطة التربوية الفردية للأطفال ذوي الاضطرابات النمائية",
                    videos: "12",
                    hours: "3",
                    discount: "50",
                    beforeDiscount: "100",
                    price: "50",
                    provider: "حبايبنا نت",
                    coverImage: 'https://png.pngtree.com/thumb_back/fh260/background/20200714/pngtree-modern-double-color-futuristic-neon-background-image_351866.jpg'
                },
                {
                    id: 12,
                    title: "المساق العلمي | مشاريع  الحياة",
                    category: ["v2", "v3"],
                    description:
                        "وريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على",
                    videos: "4",
                    hours: "90",
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: "zain",
                    coverImage: 'https://media.istockphoto.com/photos/blue-abstract-background-or-texture-picture-id1138395421?k=20&m=1138395421&s=612x612&w=0&h=FPYxPgxJBNucc79Z3fxAehsW6gvjw5jP17CJMsBRjGM='
                },
                {
                    id: 2,
                    title: "المساق الرياضي |  الحياة",
                    category: ["v3", "v7"],
                    description: "نموذج لوريم ايبسوم عربي -  فرانكوا اراب",
                    videos: "5",
                    hours: "13",
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: "حبايبنا نت",
                    coverImage: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfayPfmYCpC5nkY0XFGOvSNz42SA3nA-5L1A&usqp=CAU'
                },
                {
                    id: 3,
                    title: "المساق الرياضي |  الحياة",
                    category: ["v4"],
                    description: "نموذج لوريم ايبسوم عربي -  فرانكوا اراب",
                    videos: "5",
                    hours: "13",
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: "حبايبنا نت",
                    coverImage: 'https://m.media-amazon.com/images/I/61vkHB+nskL._AC_SX679_.jpg'
                },
                {
                    id: 4,
                    title: "المساق الرياضي |  الحياة",
                    category: "v3",
                    description: "نموذج لوريم ايبسوم عربي -  فرانكوا اراب",
                    videos: "5",
                    hours: "13",
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: "حبايبنا نت",
                    coverImage: 'https://m.media-amazon.com/images/I/61vkHB+nskL._AC_SX679_.jpg'
                },
                {
                    id: 5,
                    title: "المساق الرياضي |  الحياة",
                    category: "v3",
                    description: "نموذج لوريم ايبسوم عربي -  فرانكوا اراب",
                    videos: "5",
                    hours: "13",
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: "حبايبنا نت",
                    coverImage: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKmVaZp2KgrTbT_9_S1crM1vH2_bql1uRpfg&usqp=CAU'
                }
            ]
        };
    },
    mutations,
    actions,
    getters
};
