<template>
    <div>
        <div class="form-group">
            <label>Sutarties nr.</label>
            <input type="text" class="form-control" v-model="formData.contract_nr" name="contract_nr" placeholder="Sutarties nr." required>
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
                <label class="kt-radio d-flex flex-column-reverse">
                    <input type="radio" name="validity" class="due" v-model="formData.validity" value="unlimited"> Neterminuota
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
                            <datepicker
                                v-model="formData.validity_value"
                                :monday-first="true"
                                input-class="form-control due"
                                format="yyyy-MM-dd"
                                :language="lt"
                                :clear-button="true"
                                :typeable="true"
                                placeholder="Galioja iki..."
                                name="validity_value"></datepicker>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" v-if="formData.validity !== 'unlimited'">
                        <label class="kt-checkbox mb-0 mr-3">
                            <input type="hidden" name="validity_extended" value="0">
                            <input type="checkbox" name="validity_extended" v-model="formData.validity_extended" value="1"> Pratęsti iki:
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
                    <input type="hidden" name="validity_verbal" value="0">
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
                    <input type="radio" name="contract_status" v-model="formData.contract_status" value="įvykdyta"> Įvykdyta
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group" v-if="research_areas && research_areas.length">
            <label>Tyrimų sritys</label>
            <div>
                <template v-for="(ra,index) in research_areas">
                    <span class="kt-badge kt-badge--primary kt-badge--md kt-badge--inline kt-badge--pill mr-2" :key="`ra_${index}`">
                        {{ ra.name }}
                    </span>
                </template>
            </div>
        </div>
        <div class="form-group">
            <vue-dropzone
                ref="myVueDropzone"
                id="dropzone"
                @vdropzone-file-added="fileAdded"
                @vdropzone-success="fileUploaded"
                @vdropzone-removed-file="fileRemoved"
                :options="dropzoneOptions"></vue-dropzone>
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
                            <h5 class="modal-title">Nauja sąskaita</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="!creating">
                                <div class="form-group">
                                    <label for="invoice_nr" class="form-control-label">Sąskaitos nr:</label>
                                    <input type="text" v-model="contractInvoiceData.nr" class="form-control" id="invoice_nr">
                                </div>
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
                        <div v-if="!creating" class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                            <button type="button" class="btn btn-primary" @click.prevent="submitInvoice">Įvesti</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="font-weight-bold mb-3">Sąskaitos</div>
        <div class="kt-list-timeline" v-if="invoices">
            <div class="kt-list-timeline__items">
                <div class="kt-list-timeline__item" v-for="(invoice,index) in invoices" :key="`invoice_${index}`">
                    <span class="kt-list-timeline__badge"></span>
                    <span class="kt-list-timeline__text">
                        Sąsk. nr. <span class="underline">{{ invoice.nr ? invoice.nr : 'neįvestas' }}</span> Suma {{ invoice.total }} {{ invoice.status ? 'Apmokėta' : 'Neapmokėta' }}
                        <a href="javascript:" class="kt-badge kt-badge--brand kt-badge--inline" data-toggle="modal" data-target="#edit_invoice" @click="getInvoice(invoice.id)">redaguoti</a>
                        <a href="javascript:" class="kt-badge kt-badge--danger kt-badge--inline" @click.prevent="deleteInvoice(invoice.id)">trinti</a>
                    </span>
                    <span class="kt-list-timeline__time">{{ invoice.updated_at }}</span>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit_invoice" tabindex="-1" role="dialog" aria-labelledby="editInvoice" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Redaguoti sąskaita {{ editingInvoice.id }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="invoice_nr_edit" class="form-control-label">Sąskaitos nr:</label>
                            <input type="text" v-model="editingInvoice.nr" class="form-control" id="invoice_nr_edit">
                        </div>
                        <div class="form-group">
                            <label for="editable_invoice_value" class="form-control-label">Sąskaita (Eur):</label>
                            <input type="number" v-model="editingInvoice.total" class="form-control" id="editable_invoice_value">
                        </div>
                        <div class="form-group">
                            <label>Mokėjimo statusas</label>
                            <div class="kt-radio-inline mt-2">
                                <label class="kt-radio">
                                    <input type="radio" v-model="editingInvoice.status" value="1"> Apmokėta
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" v-model="editingInvoice.status" value="0"> Neapmokėta
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mokėjimo terminas IKI</label>
                            <datepicker
                                :monday-first="true"
                                v-model="editingInvoice.due_date"
                                input-class="form-control"
                                format="yyyy-MM-dd"
                                :language="lt" placeholder="Mokėjimo terminas IKI"></datepicker>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Uždaryti</button>
                        <button type="button" class="btn btn-primary" @click.prevent="updateInvoice">Išsaugoti</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="files">
            <input type="hidden" name="documents[]" :value="file.name" v-for="(file,index) in files" :key="`file_${index}`">
        </div>
    </div>
</template>

<style lang="scss">
    .dz-remove-download {
        right: 15px;
        left: auto;
    }
</style>

<script>
    import Datepicker from 'vuejs-datepicker'
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import {en, lt} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'contract-fields',
        props: ['contract','research_areas','documents','creating'],
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
                    validity_extended: ( this.contract ? this.contract.validity_extended : null ),
                    validity_extend_till_value: ( this.contract ? this.contract.validity_extend_till_value : null ),
                    validity_verbal: ( this.contract ? this.contract.validity_verbal : 0 ),
                    contract_status: ( this.contract ? this.contract.contract_status : [] ),
                },
                contractInvoiceData: {
                    nr: null,
                    contract_id: ( this.contract ? this.contract.id : false ),
                    total: null,
                    status: 0,
                    due_date: null,
                },
                dropzoneOptions: {
                    url: `${window.API_DOMAIN}/media`,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    maxFilesize: 5,
                    headers: { "X-CSRF-TOKEN": window.CSRF },
                    dictRemoveFile: "Trinti",

                },
                editingInvoice: false,
                invoices: [],
                files: [],
            }
        },

        components: {
            'datepicker': Datepicker,
            'vueDropzone': vue2Dropzone,
        },

        mounted() {
            this.contractInvoiceData.due_date = this.defaultDueDate();
            this.invoices = this.getInvoices();
            this.files = (typeof this.documents !== 'undefined' ? this.documents : []);

            if ( this.files ) {
                this.files.forEach( (file) => {
                    this.$refs.myVueDropzone.manuallyAddFile(file, file.url);
                } );
            }
        },

        methods: {
            fileUploaded(file, response) {
                this.files.push(response);
            },

            fileRemoved(file) {
                this.files = this.files.filter( (obj) => {
                    return obj.original_name !== file.name;
                } );

                if ( typeof file.id !== 'undefined' ) {
                    this.$http.delete(`media/${file.id}`);
                }
            },

            fileAdded(file){
                console.log(file);
                const a = document.createElement('a');
                a.setAttribute('href',file.url);
                a.setAttribute('class','dz-remove dz-remove-download');
                a.innerHTML = "atsisiųsti";
                file.previewTemplate.appendChild(a);
            },

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

                    if ( typeof invoice.id !== 'undefined'  ) {
                        $('.modal').modal('hide');
                        this.invoices.push(invoice);
                        toastr.success("Sąskaita pridėta.");
                    } else {
                        toastr.error("Visi laukai yra privalomi.");
                    }
                })
            },

            updateInvoice() {
                this.$http.put(`invoices/${this.contract.id}`, this.editingInvoice).then((response) => {
                    const invoice = response.data;

                    if ( typeof invoice.id !== 'undefined' ) {
                        $('.modal').modal('hide');
                        this.getInvoices();
                        toastr.success("Sąskaita atnaujinta.");
                    }
                })
            },

            getInvoices() {
                if ( typeof this.contract !== 'undefined' ) {
                    this.$http.get(`invoices/${this.contract.id}`).then( (response) => {
                        this.invoices = response.data;
                    } );
                }
            },

            getInvoice(invoice_id) {
                if ( typeof this.contract !== 'undefined' ) {
                    this.$http.get(`invoices/${this.contract.id}/${invoice_id}`).then( (response) => {
                        this.editingInvoice = response.data;
                    } );
                }
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
