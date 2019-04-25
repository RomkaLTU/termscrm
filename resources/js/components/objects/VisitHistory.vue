<template>
    <div>
        <button type="button"
                @click.prevent="getVisitHistory"
                class="btn btn-outline-brand btn-sm"
                data-toggle="modal"
                :data-target="`#visit_history_${object_id}`">
            Peržiūrėti
        </button>
        <div class="modal fade" :id="`visit_history_${object_id}`" tabindex="-1" role="dialog" aria-labelledby="visitHistory" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visitHistory">Apsilankymų istorija</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="kt-scroll" data-scroll="true" data-height="200">
                            <div class="kt-list-timeline" v-if="visits.length">
                                <div class="kt-list-timeline__items">
                                    <div class="kt-list-timeline__item" v-for="visit in visits" :key="`visit_${visit.id}`">
                                        <span class="kt-list-timeline__badge"></span>
                                        <span class="kt-list-timeline__text">{{ visit.user.name }}</span>
                                        <span class="kt-list-timeline__time">{{ visit.created_at }}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <p>Apsilankymų nebuvo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'visits-history',
        props: ['contract_id','object_id'],
        data() {
            return {
                visits: [],
            }
        },
        methods: {
            getVisitHistory() {
                this.$http.get(`visits/${this.contract_id}/${this.object_id}`).then( (response) => {
                    this.visits = response.data;
                } );
            }
        },
    }
</script>

<style lang="scss" scoped>
    .kt-list-timeline .kt-list-timeline__items .kt-list-timeline__item .kt-list-timeline__time {
        width: 130px;
    }
</style>
