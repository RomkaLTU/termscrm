<template>
    <label class="kt-checkbox">
        <input type="checkbox" name="visits[]" @change="toggleVisit"
               :checked="false"
               :data-contractid="contract_id"
               :value="object_id"> &nbsp;
        <span></span>
    </label>
</template>

<script>
    export default {
        name: 'check-visited',
        props: ['object_id','contract_id'],
        methods: {
            toggleVisit(value){
                this.$store.dispatch('objektai/setMarketVisited', {
                    state: value.target.checked,
                    contract_id: value.target.dataset.contractid,
                    value: value.target.value,
                });
            },
        },
    }
</script>
