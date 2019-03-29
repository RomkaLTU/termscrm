<template>
    <div>
        <div class="form-group">
            <label>Sutarties nr.</label>
            <input type="text" class="form-control" v-model="formData.contract_nr" name="contract_nr" placeholder="Sutarties nr.">
        </div>
        <div class="form-group">
            <label>Adresas</label>
            <input type="text" class="form-control" v-model="formData.customer_address" name="customer_address" placeholder="Adresas">
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
        <div class="form-group">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_invoice"><i class="fa fa-plus"></i> Pridėti sąskaitą</button>
            <div class="modal fade" id="add_invoice" tabindex="-1" role="dialog" aria-labelledby="addInvoice" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nauja sąskaita</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="formData.contract_nr">
                                <div class="form-group">
                                    <label for="invoice_value" class="form-control-label">Sąskaita (Eur):</label>
                                    <input type="number" v-model="contractInvoiceData.total" class="form-control" id="invoice_value">
                                </div>
                                <div class="form-group">
                                    <label>Mokėjimo statusas</label>
                                    <div class="kt-radio-inline mt-2">
                                        <label class="kt-radio">
                                            <input type="radio" v-model="contractInvoiceData.status" value="1"> Apmokėta
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio" v-model="contractInvoiceData.status" value="0"> Neapmokėta
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mokėjimo terminas IKI</label>
                                    <datepicker
                                        :monday-first="true"
                                        v-model="contractInvoiceData.due_date"
                                        input-class="form-control"
                                        format="yyyy-MM-dd"
                                        :language="lt" placeholder="Mokėjimo terminas IKI"></datepicker>
                                </div>
                            </div>
                            <div v-else>
                                <p>Sąskaitą bus galima įvesti po sutarties sukūrimo</p>
                            </div>
                        </div>
                        <div v-if="formData.contract_nr" class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                            <button type="button" class="btn btn-primary" @click.prevent="submitInvoice">Įvesti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-list-timeline">
            <div class="kt-list-timeline__items">
                <div class="kt-list-timeline__item" v-for="(invoice,index) in invoices" :key="`invoice_${index}`">
                    <span class="kt-list-timeline__badge"></span>
                    <span class="kt-list-timeline__text">
                        Sąsk. nr. {{ invoice.id }} Suma {{ invoice.total }} {{ invoice.status ? 'Apmokėta' : 'Neapmokėta' }}
                        <a href="javascript:" class="kt-badge kt-badge--brand kt-badge--inline">redaguoti</a>
                        <a href="javascript:" class="kt-badge kt-badge--danger kt-badge--inline" @click.prevent="deleteInvoice(invoice.id)">trinti</a>
                    </span>
                    <span class="kt-list-timeline__time">{{ invoice.updated_at }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import {en, lt} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'contract-fields',
        props: ['contract','research_areas'],
        data() {
            return {
                en: en,
                lt: lt,
                formData: {
                    contract_nr: ( this.contract ? this.contract.contract_nr : null ),
                    customer_address: ( this.contract ? this.contract.customer_address : null ),
                    customer: ( this.contract ? this.contract.customer : null ),
                    contract_value: ( this.contract ? this.contract.contract_value : null ),
                    validity: ( this.contract ? this.contract.validity : null ),
                    validity_value: ( this.contract ? this.contract.validity_value : null ),
                    validity_extend_till: ( this.contract ? this.contract.validity_extend_till : null ),
                    validity_extend_till_value: ( this.contract ? this.contract.validity_extend_till_value : null ),
                    validity_verbal: ( this.contract ? this.contract.validity_verbal : null ),
                    research_area: ( this.research_areas ? this.research_areas : [] ),
                    contract_status: ( this.contract ? this.contract.contract_status : [] ),
                },
                contractInvoiceData: {
                    contract_id: this.contract.id,
                    total: null,
                    status: 0,
                    due_date: null,
                },
                invoices: [],
            }
        },

        components: {
            'datepicker': Datepicker,
        },

        mounted() {
            this.contractInvoiceData.due_date = this.defaultDueDate();
            this.invoices = this.getInvoices();
        },

        methods: {
            defaultDueDate() {
                const now = new Date();
                if (now.getMonth() === 11) {
                    return new Date(now.getFullYear() + 1, 0, 1).format("Y-m-d");
                } else {
                    let date = new Date(now.getFullYear(), now.getMonth() + 1, 1);
                    let m = ("0" + (date.getMonth())).slice(-2);
                    let d = ("0" + (date.getDate())).slice(-2);
                    return `${date.getFullYear()}-${m}-${d}`;
                }
            },

            submitInvoice() {
                this.$http.post('invoices', this.contractInvoiceData).then((response) => {
                    const invoice = response.data;

                    if ( typeof invoice.id !== 'undefined' ) {
                        $('.modal').modal('hide');
                        this.invoices.push(invoice);
                        toastr.success("Sąskaita pridėta.");
                    }
                })
            },

            getInvoices() {
                this.$http.get(`invoices/${this.contract.id}`).then( (response) => {
                    this.invoices = response.data;
                } );
            },

            deleteInvoice(invoice_id) {
                this.$http.delete(`invoices/${invoice_id}`).then( (response) => {
                    const invoice = response.data;

                    if ( typeof invoice.id !== 'undefined' ) {
                        this.getInvoices();
                        toastr.success("Sąskaita panaikinta.");
                    }
                } );
            },
        }
    }
</script>
