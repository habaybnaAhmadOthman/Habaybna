export default {
    data() {
        return {
            infoModal: {
                title: 'لقد أتممت عملية الشراء بنجاح',
                description: 'يمكنك الآن مشاهدة الدورة',
                status: true,
                show: false
            }
        };
    },
    methods: {
        closeInfoModal(){
            this.infoModal.show = false
        }
    }
}