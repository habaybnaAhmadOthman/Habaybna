export default {
    data() {
        return {
            infoModal: {
                title: 'لقد أتممت عملية الشراء بنجاح',
                description: 'يمكنك الآن مشاهدة الدورة',
                status: true,
                show: false,
                isFixed: false,
            }
        };
    },
    methods: {
        closeInfoModal(){
            this.infoModal.show = false
        },
        setInfoModal(title,desc,status,isFixed,show){
            this.infoModal.title = title
            this.infoModal.description = desc
            this.infoModal.status = status
            this.infoModal.isFixed = isFixed
            this.infoModal.show = show
        }
    }
}