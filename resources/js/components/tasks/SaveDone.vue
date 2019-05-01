<template>
    <button class="btn btn-success btn-icon-sm" @click.prevent="saveDone" v-if="getMarkedDone.length">
        <i class="la la-check"></i>
        Tvirtinti atliktus darbus ({{ getMarkedDone.length }})
    </button>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: 'task-save-done',
        computed: {
            ...mapGetters('tasks',[
                'getMarkedDone'
            ])
        },
        methods: {
            saveDone(){
                this.$http.post(`tasks`, {
                    checked: this.getMarkedDone,
                    user_id: window.USER_ID,
                }).then( () => {
                    toastr.success("Statusas išsaugotas");
                } );
            },
        },
    }
</script>
