<template>
    <div @click="tagClicked" :class="isSelected" class="border trans radius-12 p-10 font-14 radio-tag d-flex space-between align-center pointer">
        <span class="bold top-2">{{labelName}}</span>
        <span class="top-2">{{labelValue}}</span>
    </div>
</template>

<script>
    export default {
        emits: ['on-day-select','on-time-select'],
        props: ['isDay','item'],
        computed: {
            labelName(){
                if (this.isDay)
                    return new Date(this.item.intervals[0].date).toLocaleDateString('ar-EG',{weekday:'long'})
                else
                    return new Date(this.item.date).toLocaleDateString('en-US',{hour:'2-digit',minute:'2-digit'}).split(' ')[1]
            },
            labelValue(){
                if (this.isDay)
                    return new Date(this.item.intervals[0].date).toLocaleDateString('en-GB',{month:'numeric',day:'2-digit'})
                else {
                    var AM_PM = new Date(this.item.date).toLocaleDateString('en-US',{hour:'2-digit',minute:'2-digit'}).split(' ')[2];
                    return AM_PM.toLowerCase() == 'pm' ? 'مساءً' : 'صباحاً'
                }
            },
            isSelected(){
                return this.item.selected ? 'active' : ''
            }
        },
        methods: {
            tagClicked(){
                let dayOrTime = this.isDay ? 'day' : 'time'
                this.$emit(`on-${dayOrTime}-select`,this.item.id)
            }
        }
    }
</script>

<style scoped>
.radio-tag {
    border: 2px solid #00000029;
    min-width: 120px;
}
.radio-tag.active {
    background: #FF9E00;
    color: #fff;
}
</style>