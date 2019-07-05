<template>
    <div class="kt-quick-search kt-quick-search--inline" id="kt_quick_search_inline">
        <div class="kt-quick-search__form">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                <input v-model="search" @keyup.enter.prevent="doSearch" type="text" class="form-control" placeholder="Ieškoti...">
                <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
            </div>
        </div>
        <div :class="['kt-quick-search__wrapper','kt-scroll',{'d-block':results_contracts.length}]" data-scroll="true" data-height="300" data-mobile-height="200">
            <div class="kt-quick-search__result">
                <div class="kt-quick-search__category kt-quick-search__category--first">
                    Rastos sutartys
                </div>
                <a :href="`/contracts/${contract.id}`" class="kt-quick-search__item" v-for="contract in results_contracts" :key="`contract_${contract.id}`">
                    <span class="kt-quick-search__item-text">{{ contract.contract_nr }} ({{ contract.customer }})</span>
                </a>
            </div>
        </div>
        <div :class="['kt-quick-search__wrapper','kt-scroll',{'d-block':results_objs.length}]" data-scroll="true" data-height="300" data-mobile-height="200">
            <div class="kt-quick-search__result">
                <div class="kt-quick-search__category kt-quick-search__category--first">
                    Rasti objektai
                </div>
                <template v-for="object in results_objs">
                    <a v-if="object.contract[0]" :href="`/contracts/${object.contract[0].id}/objects/${object.id}/edit`" class="kt-quick-search__item" :key="`object_${object.id}`">
                        <span class="kt-quick-search__item-text">
                            {{ object.name }}<br>
                            Sutartis: {{ object.contract[0].contract_nr }}
                        </span>
                    </a>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'quick-search',
        data(){
            return {
                search: null,
                results_contracts: [],
                results_objs: [],
            }
        },
        methods: {
            doSearch(){
                this.$http.get(`contracts?search=${this.search}`).then((response) => {
                    this.results_contracts = response.data;
                });

                this.$http.get(`objects?search=${this.search}`).then((response) => {
                    this.results_objs = response.data;
                });
            },
        },
    }
</script>
