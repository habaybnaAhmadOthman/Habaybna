import getters from './getters'
import actions from './actions'
import mutations from './mutations'
export default {
    namespaced: true,
    state(){
        return {
            courses: [
                {
                    id: 1,
                    title: 'المساق الرقمي | مشاريع مستدامة من أجل الحياة',
                    category: 'v1',
                    description: 'في هذا الجزء من المساق سيتم استعراض أهم الأسس في مجال اختبارات الذكاء عند تصميم الخطة التربوية الفردية للأطفال ذوي الاضطرابات النمائية',
                    videos: '12',
                    hours: '3',
                    discount: '50',
                    beforeDiscount: '100',
                    price: '50',
                    provider: 'حبايبنا نت'
                },
                {
                    id: 2,
                    title: 'المساق العلمي | مشاريع  الحياة',
                    category: 'v2',
                    description: 'وريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على',
                    videos: '4',
                    hours: '90',
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: 'zain'
                },
                {
                    id: 3,
                    title: 'المساق الرياضي |  الحياة',
                    category: 'v3',
                    description: 'نموذج لوريم ايبسوم عربي -  فرانكوا اراب',
                    videos: '5',
                    hours: '13',
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: 'حبايبنا نت'
                },
                {
                    id: 3,
                    title: 'المساق الرياضي |  الحياة',
                    category: 'v3',
                    description: 'نموذج لوريم ايبسوم عربي -  فرانكوا اراب',
                    videos: '5',
                    hours: '13',
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: 'حبايبنا نت'
                },
                {
                    id: 3,
                    title: 'المساق الرياضي |  الحياة',
                    category: 'v3',
                    description: 'نموذج لوريم ايبسوم عربي -  فرانكوا اراب',
                    videos: '5',
                    hours: '13',
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: 'حبايبنا نت'
                },
                {
                    id: 3,
                    title: 'المساق الرياضي |  الحياة',
                    category: 'v3',
                    description: 'نموذج لوريم ايبسوم عربي -  فرانكوا اراب',
                    videos: '5',
                    hours: '13',
                    discount: null,
                    beforeDiscount: null,
                    price: null,
                    provider: 'حبايبنا نت'
                },
            ]
        }
    },
    mutations,
    actions,
    getters,
}