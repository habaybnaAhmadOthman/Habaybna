<template>
    <div class="tabs-toggle relative">
        <button v-for="(tab,index) in tabs" :key="index" @click="toggletab" :tab-toggle="tab.name" :class="isActive(tab.active)" v-html="tab.title"></button>
    </div>
</template>

<script>
    export default {
        props: ['tabs'],
        methods: {
            toggletab(e) {
                document.querySelector(".tabs-toggle .active").classList.remove("active");
                e.target.classList.add("active");
                const activeTab = e.target.getAttribute("tab-toggle");
                
                document.querySelector("[tab-name].active").classList.remove("active");
                document.querySelector("[tab-name='"+ activeTab +"']").classList.add('active')
            },
            isActive(isActive){
                return isActive ? 'active' : '' ;
            }
        }
    }
</script>

<style scoped>

.tabs-toggle {
    display: flex;
    border-bottom: 1px solid #939598;
}
button {
    flex: 1;
    background: transparent;
    border: 0;
    color: #780d93;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    padding: 5px 2px 15px 2px;
    transition: .3s;
    position: relative;
}
button.active:after {
    position: absolute;
    content: '';
    display: block;
    width: 100%;
    background: #E58C01;
    height: 3px;
    bottom: 0;
    border-radius: 10px;
    bottom: -1.5px;
}
@media (min-width: 768px) {
    button {
        font-size: 22px;
        cursor: pointer;
        flex: inherit;
        margin-left: 30px;
    }
    .tabs-toggle {
        border-bottom: 1px solid #00000029;
    }
    .swipe-box-p button.active:after{
        bottom: 0;
    }
    
}
@media (max-width: 767px) {
    .font-14-mo * {
        font-size: 14px!important;
    }
    button {
        font-size: 14px;
    }
    button:after{
        content: none !important;
    }
    button.active{
        background: #FF9E00;
        border-radius: 8px 8px 0 0;
        color: #fff;
    }
}
</style>