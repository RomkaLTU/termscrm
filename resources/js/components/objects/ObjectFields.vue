<template>
    <div>
        <div class="form-group">
            <label for="pavadinimas">Pavadinimas</label>
            <input type="text" class="form-control" id="pavadinimas" v-model="formData.name" name="name" placeholder="Pavadinimas">
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
                    <label class="kt-checkbox" v-for="ra in research_areas" :key="`ra_${ra.id}`">
                        <input type="checkbox" name="research_area[]" v-model="formData.research_area" :value="ra.id"> {{ ra.name }}
                        <span></span>
                    </label>
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
        props: ['obj','research_areas','research_area','contract','documents'],

        data() {
            return {
                en: en,
                lt: lt,
                formData: {
                    name: ( this.obj ? this.obj.name : null ),
                    details: ( this.obj ? this.obj.details : null ),
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
        }
    }
</script>
