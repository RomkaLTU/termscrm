<template>
    <button class="btn btn-success btn-icon-sm" @click.prevent="saveVisited" v-if="getMarkedVisited.length">
        <i class="la la-check"></i>
        Saugoti aplankytus ({{ getMarkedVisited.length }})
    </button>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: 'save-visited',
        computed: {
            ...mapGetters('objektai',[
                'getMarkedVisited'
            ])
        },
        methods: {
            saveVisited(){
                this.$http.post(`visits`, {
                    checked: this.getMarkedVisited,
                    user_id: window.USER_ID,
                }).then( (response) => {
                    toastr.success("Apsilankymai išsaugoti");
                } );
            },
        },
    }
</script>
