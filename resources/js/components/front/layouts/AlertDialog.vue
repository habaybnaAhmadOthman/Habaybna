<template>
    <portal v-if="portal" :to="portalFn">
        <aside :class="modalClass" class="z-1000">
            <div v-if="show" class="w-100 h-100 backdrop" @click="tryClose"></div>
            <transition name="modal">
                <dialog
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
                    <menu class="d-flex flex-end ml-10 mb-10 mr-10 modal-footer">
                        <slot name="actions">
                            <button class="btn mb-10 ml-10" @click="tryClose">
                                حسنا
                            </button>
                        </slot>
                    </menu>
                </dialog>
            </transition>
        </aside>
    </portal>
    <aside :class="modalClass" v-else>
        <div v-if="show" class="w-100 h-100 backdrop" @click="tryClose"></div>
        <transition name="modal">
            <dialog
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
                <menu class="d-flex flex-end ml-10 mb-10 mr-10 modal-footer">
                    <slot name="actions">
                        <button class="btn mb-10 ml-10" @click="tryClose">
                            حسنا
                        </button>
                    </slot>
                </menu>
            </dialog>
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
        modalClass: {
            type: String,
            required: false
        },
        portal: {
            type: String,
            required: false
        },
    },
    emits: ["close"],
    methods: {
        tryClose() {
            this.$emit("close");
        }
    },
    computed: {
        portalFn(){
            return this.portal || "destination";
        }
    }
};
</script>

<style scoped>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999999;
    background-color: rgba(0, 0, 0, 0.75);
}
dialog {
    position: fixed;
    top: 7vh;
    left: 10%;
    z-index: 999999990;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
    right: 0;
    left: 0;
    margin: auto;
    width:500px;
}
.header {
    background-color: #660066;
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
aside {
    z-index: 99999999999999;
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
.user-image-modal dialog {
    top: 10%;
}
.user-image-modal .modal-footer {
    width: 460px;
    margin: 0 auto 10px auto;
}
@media (max-width: 767px) {
    dialog {
        top: 5%;
    }
    .body {
        max-height: 75vh;
    }
    .modal-body, .user-image-modal .modal-footer,.user-image-modal .modal-footer {
        width: 100%!important;
    }
    .user-image-modal .modal-footer {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>
