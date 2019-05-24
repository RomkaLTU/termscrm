<template>
    <div>
        <div class="form-group">
            <label for="pavadinimas">Pavadinimas</label>
            <input type="text" class="form-control" id="pavadinimas" v-model="formData.name" name="name" placeholder="Pavadinimas">
        </div>
        <div class="form-group row">
            <div class="col-lg-3">
                <label for="regions">Regionas</label>
                <select id="regions" class="form-control m-select2" name="region_id">
                    <option value=""></option>
                    <option
                        v-for="region in regions"
                        :key="`region_${region.id}`"
                        :selected="region_selected===region.id"
                        :value="region.id">
                        {{ region.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label>Lankymo laikas</label>
                <div class="d-flex align-items-center mt-1">
                    <div class="d-flex w-100">
                        <div class="d-flex align-items-center mr-2" style="flex:1">
                            <div class="w-100">
                                <datepicker
                                    v-model="formData.visit_time"
                                    :monday-first="true"
                                    input-class="form-control w-100"
                                    format="yyyy-MM-dd"
                                    :language="lt"
                                    v-on:selected="visitTimeChange"
                                    placeholder="Pasirinkite datą"
                                    name="due_date"></datepicker>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="flex:1">
                            <div class="w-100">
                                <select id="visit_time_req" class="w-100" @change="requiringIntChange" name="visit_time_req">
                                    <option value="">Reguliariai</option>
                                    <option :selected="obj.visit_time_req==='2k. / mėn.'">2k. / mėn.</option>
                                    <option :selected="obj.visit_time_req==='1k. / mėn.'">1k. / mėn.</option>
                                    <option :selected="obj.visit_time_req==='1k. / ketv.'">1k. / ketv.</option>
                                    <option :selected="obj.visit_time_req==='2k. / met.'">2k. / met.</option>
                                    <option :selected="obj.visit_time_req==='1k. / met.'">1k. / met.</option>
                                    <option :selected="obj.visit_time_req==='Kita'">Kita</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="rekvizitai">Rekvizitai</label>
            <textarea class="form-control" id="rekvizitai" rows="3" v-model="formData.details" name="details" placeholder="Rekvizitai"></textarea>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="notes_1">Pastabos 1</label>
                <textarea class="form-control" id="notes_1" rows="3" v-model="formData.notes_1" name="notes_1" placeholder="Pastabos 1"></textarea>
            </div>
            <div class="col-lg-6">
                <label for="notes_2">Pastabos 2</label>
                <textarea class="form-control" id="notes_2" rows="3" v-model="formData.notes_2" name="notes_2" placeholder="Pastabos 2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Tyrimo sritys</label>
                <div class="kt-checkbox-inline mt-2">
                    <div class="research-area-type" v-for="ra in research_areas" :key="`ra_${ra.id}`">
                        <label class="kt-checkbox mb-0">
                            <input type="checkbox" name="research_area[]" v-model="formData.research_area" :value="ra.id"> {{ ra.name }}
                            <span></span>
                        </label>
                        <div class="user-select-wrap">
                            <select class="form-control m-select2 research_areas_users" :name="`ra_supervisor[${ra.id}]`">
                                <option value=""></option>
                                <option :value="user.id" :selected="(supervisors && supervisors[ra.id] === user.id)"  v-for="user in users" :key="`user_${ra.id}_${user.id}`">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <vue-dropzone
                ref="myVueDropzone"
                id="dropzone"
                @vdropzone-success="fileUploaded"
                @vdropzone-removed-file="fileRemoved"
                :options="dropzoneOptions"></vue-dropzone>
        </div>
        <div v-if="files">
            <input type="hidden" name="documents[]" :value="file.name" v-for="(file,index) in files" :key="`file_${index}`">
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import {en, lt} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'obj-fields',
        props: [
            'obj',
            'research_areas',
            'research_area',
            'contract',
            'documents',
            'users',
            'supervisors',
            'regions',
            'region_selected'
        ],
        data() {
            return {
                en: en,
                lt: lt,
                formData: {
                    name: ( this.obj ? this.obj.name : null ),
                    details: ( this.obj ? this.obj.details : null ),
                    visit_time: ( this.obj ? this.obj.due_date : null ),
                    notes_1: ( this.obj ? this.obj.notes_1 : null ),
                    notes_2: ( this.obj ? this.obj.notes_2 : null ),
                    research_area: ( this.research_area ? this.research_area : [] ),
                },
                dropzoneOptions: {
                    url: `${window.API_DOMAIN}/media`,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    addRemoveLinks: true,
                    maxFilesize: 5,
                    headers: { "X-CSRF-TOKEN": window.CSRF }
                },
                files: [],
            }
        },

        components: {
            'datepicker': Datepicker,
            'vueDropzone': vue2Dropzone,
        },
        mounted() {
            this.files = (typeof this.documents !== 'undefined' ? this.documents : []);
            if ( this.files ) {
                this.files.forEach( (file) => {
                    this.$refs.myVueDropzone.manuallyAddFile(file, file.url);
                } );
            }

            $('#visit_time_req').on('select2:select', () => {
                this.formData.visit_time = null;
            });
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
            visitTimeChange() {
                this.formData.visit_time_req = null;
                $('#visit_time_req').val('').change();
            },
            requiringIntChange() {
                this.formData.visit_time = null;
            },
        }
    }
</script>

<style lang="scss">
    .user-select-wrap {
        width: 100%;
        max-width: 250px;
    }

    .research-area-type {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 470px;
        margin-bottom: 1rem;
    }
</style>
