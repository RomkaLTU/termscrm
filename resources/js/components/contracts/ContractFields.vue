<template>
    <div>
        <div class="form-group">
            <label>Sutarties nr.</label>
            <input type="text" class="form-control" v-model="formData.contract_nr" name="contract_nr" placeholder="Sutarties nr.">
        </div>
        <div class="form-group">
            <label>Adresas</label>
            <input type="text" class="form-control" v-model="formData.address" name="address" placeholder="Adresas">
        </div>
        <div class="form-group">
            <label>Užsakovas</label>
            <input type="text" class="form-control" v-model="formData.customer" name="customer" placeholder="Užsakovas">
        </div>
        <div class="form-group">
            <label>Galiojimas</label>
            <div class="kt-radio-inline mt-2">
                <label class="kt-radio">
                    <input type="radio" name="validity" v-model="formData.validity" value="unlimited"> Neterminuota
                    <span></span>
                </label>
            </div>
            <div class="d-flex align-items-center mt-1">
                <div class="d-flex">
                    <div class="d-flex align-items-center mr-5">
                        <label class="kt-radio mb-0 mr-3">
                            <input type="radio" name="validity" v-model="formData.validity" value="todate"> Iki:
                            <span></span>
                        </label>
                        <div>
                            <datepicker v-model="formData.validity_value" :monday-first="true" input-class="form-control" format="yyyy-MM-dd" :language="lt" placeholder="Galioja iki..." name="validity_value"></datepicker>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="kt-checkbox mb-0 mr-3">
                            <input type="checkbox" name="validity_extend_till" v-model="formData.validity_extend_till" value="extend_till"> Pratęsti iki:
                            <span></span>
                        </label>
                        <div>
                            <datepicker v-model="formData.validity_extend_till_value" :monday-first="true" name="validity_extend_till_value" input-class="form-control" format="yyyy-MM-dd" :language="lt" placeholder="Pratęsti iki..."></datepicker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-checkbox-inline mt-3">
                <label class="kt-checkbox">
                    <input type="checkbox" name="validity_verbal" v-model="formData.validity_verbal" value="1"> Žodinė
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>Sutarties statusas</label>
            <div class="kt-radio-inline mt-2">
                <label class="kt-radio">
                    <input type="radio" name="contract_status" v-model="formData.contract_status" value="galiojanti"> Galiojanti
                    <span></span>
                </label>
                <label class="kt-radio">
                    <input type="radio" name="contract_status" v-model="formData.contract_status" value="sustabdyta"> Sustabdyta
                    <span></span>
                </label>
                <label class="kt-radio">
                    <input type="radio" name="contract_status" v-model="formData.contract_status" value="ivykdyta"> Įvykdyta
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>Tyrimo sritys</label>
            <div class="kt-checkbox-inline mt-2">
                <label class="kt-checkbox">
                    <input type="checkbox" name="research_area[]" v-model="formData.research_area" value="1"> Orai
                    <span></span>
                </label>
                <label class="kt-checkbox">
                    <input type="checkbox" name="research_area[]" v-model="formData.research_area" value="2"> Nuotekos
                    <span></span>
                </label>
                <label class="kt-checkbox">
                    <input type="checkbox" name="research_area[]" v-model="formData.research_area" value="3"> Geriamas vanduo
                    <span></span>
                </label>
                <label class="kt-checkbox">
                    <input type="checkbox" name="research_area[]" v-model="formData.research_area" value="4"> Geologija
                    <span></span>
                </label>
                <label class="kt-checkbox">
                    <input type="checkbox" name="research_area[]" v-model="formData.research_area" value="5"> Rašto darbai
                    <span></span>
                </label>
                <label class="kt-checkbox">
                    <input type="checkbox" name="research_area[]" v-model="formData.research_area" value="6"> Kita
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>Sutarties suma</label>
            <input type="number" class="form-control" v-model="formData.contract_value" name="contract_value" placeholder="Sutarties suma">
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import {en, lt} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'contract-fields',
        data() {
            return {
                en: en,
                lt: lt,
                formData: {
                    contract_nr: ( this.contract_nr ? this.contract_nr : null ),
                    address: ( this.address ? this.address : null ),
                    customer: ( this.customer ? this.customer : null ),
                    contract_value: ( this.contract_value ? this.contract_value : null ),
                    validity: ( this.validity ? this.validity : null ),
                    validity_value: ( this.validity_value ? this.validity_value : null ),
                    validity_extend_till: ( this.validity_extend_till ? this.validity_extend_till : null ),
                    validity_extend_till_value: ( this.validity_extend_till_value ? this.validity_extend_till_value : null ),
                    validity_verbal: ( this.validity_verbal ? this.validity_verbal : null ),
                    research_area: ( this.research_area ? this.research_area : [] ),
                    contract_status: ( this.contract_status ? this.contract_status : [] ),
                },
            }
        },

        components: {
            'datepicker': Datepicker,
        },

        mounted() {

        },
    }
</script>
