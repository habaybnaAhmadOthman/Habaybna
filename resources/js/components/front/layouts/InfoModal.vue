<template>
    <aside :class="modalClass">
        <div v-if="show" class="w-100 h-100 backdrop" @click="tryClose"></div>
        <transition name="modal">
            <dialog
                class="overflow-hidden bg-white w-50 w-90-p info-modal"
                v-if="show"
                open
            >
                <div class="modal-body">
                    <img v-if="!fixed" @click="tryClose" class="close-icon-modal pointer" src="/images/close-icon-color.png" width="34" height="34" />
                    <img class="mb-40" :src="`/images/${statusIcon}.png`" width="100" height="100" />
                    <p class="title-line font-27 mb-20">{{title}}</p>
                    <p class="black-2 font-27 mb-40">{{description}}</p>
                    <div class="d-flex modal-options flex-end" :class="optionsClass">
                        <slot></slot>
                    </div>
                </div>
            </dialog>
            <!-- <dialog
                class="overflow-hidden bg-white w-50 w-90-p radius-12 border-0 m-0 p-0 alert-modal"
                v-if="show"
                open
            >
                <div class="header white w-100 p-side-15 pt-15 pb-15 pt-10-p pb-10-p">
                    <slot name="header">
                        <p class="bold font-20 font-16-p">{{ title }}</p>
                    </slot>
                </div>
                <section class="p-side-15 pt-15 pb-15 body">
                    <slot></slot>
                </section>
                <menu class="d-flex flex-end ml-10 mb-10 modal-footer">
                    <slot name="actions">
                        <button class="btn mb-10 ml-10" @click="tryClose">
                            حسنا
                        </button>
                    </slot>
                </menu>
            </dialog> -->
        </transition>
    </aside>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        title: {
            type: String,
            required: false
        },
        description: {
            type: String,
            required: false
        },
        success: {
            type: Boolean,
            required: false
        },
        modalClass: {
            type: String,
            required: false
        },
        fixed: {
            type: Boolean,
            required: false,
            default: false
        },
        optionsClass: {
            type: String,
            required: false,
            default: ''
        }
    },
    emits: ["close"],
    methods: {
        tryClose() {
            if (!this.fixed)
                this.forceClose()
        },
        forceClose() {
            this.$emit("close");
        }
    },
    computed: {
        statusIcon() {
            if (!this.success) {
                return 'error-icon'
            }
            return 'success-icon'
        }
    }
};
</script>

<style scoped>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    background-color: rgba(0, 0, 0, 0.75);
}
dialog {
    position: fixed;
    top: 10vh;
    left: 10%;
    z-index: 1000;
    right: 0;
    left: 0;
    margin: auto;
    width:800px;
    box-shadow: 0px 0px 10px #0000001A;
    border-radius: 20px;
    padding: 60px 80px;
}

.modal-enter-active {
    animation: modal 0.3s ease-out;
}

.modal-leave-active {
    animation: modal 0.3s ease-in reverse;
}
.body {
    max-height: 450px;
    overflow-y: auto;
}
.close-icon-modal {
    position: absolute;
    left: 50px;
    top: 50px;
}
.btn {
    width: 340px;
    font-size: 18px;
    font-weight: bold;
    height: 60px;
    border-radius: 25px;
}
@keyframes modal {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
.space-between-i {
    justify-content: space-between!important;
}
</style>
