<template>
    <div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="pavadinimas">Pavadinimas</label>
                <input type="text" class="form-control" id="pavadinimas" v-model="formData.name" name="name" placeholder="Pavadinimas">
            </div>
            <div class="col-lg-6">
                <label for="tyrimoSritys">Tyrimo sritis</label>
                <select class="form-control" v-model="formData.research_area" id="tyrimoSritys" >
                    <option>Pasirinkite</option>
                    <option v-for="area in research_areas" :key="`area_${area.id}`" :value="area.id">
                        {{ area.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label class="kt-checkbox mb-0 mr-3" v-show="fields.special_task.some((item) => Number(item) === formData.research_area)">
                    <input type="checkbox" name="special_task" v-model="formData.special_task" value="requiring"> Spec. užduotis
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Atlikti iki</label>
                <div class="d-flex align-items-center mt-1">
                    <div class="d-flex">
                        <div class="d-flex align-items-center mr-5">
                            <label class="kt-radio mb-0 mr-3">
                                <input type="radio" name="deadline" v-model="formData.deadline" value="todate"> Pasirinkta data:
                                <span></span>
                            </label>
                            <div>
                                <datepicker
                                    v-model="formData.deadline_value"
                                    :monday-first="true"
                                    input-class="form-control"
                                    format="yyyy-MM-dd"
                                    :language="lt"
                                    placeholder="Atlikti iki..."
                                    name="validity_value"></datepicker>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <label class="kt-radio mb-0 mr-3">
                                <input type="radio" name="deadline" v-model="formData.requiring" value="requiring"> Reguliarus:
                                <span></span>
                            </label>
                            <div>
                                <select class="form-control" v-model="formData.requiring_value" name="requiring_value">
                                    <option value="2_m">2k. / mėn.</option>
                                    <option value="1_m">1k. / mėn.</option>
                                    <option value="1_q">1k. / ketv.</option>
                                    <option value="2_y">2k. / met.</option>
                                    <option value="1_y">1k. / met.</option>
                                    <option value="other">Kita</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="note_1">Pastabos 1</label>
                <input type="text" class="form-control" id="note_1" v-model="formData.note_1" name="note_1" placeholder="Pastabos 1">
            </div>
            <div class="col-lg-6">
                <label for="note_2">Pastabos 2</label>
                <input type="text" class="form-control" id="note_2" v-model="formData.note_2" name="note_2" placeholder="Pastabos 2">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label class="kt-checkbox mb-0 mr-3" v-show="fields.ecog.some((item) => Number(item) === formData.research_area)">
                    <input type="checkbox" name="ecog" v-model="formData.ecog" value="1"> Ekogeologinis
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import {en, lt} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'task-fields',
        props: ['obj','research_areas','research_area','contract','documents','task'],
        data() {
            return {
                en: en,
                lt: lt,
                fields: {
                    special_task: ['1','4'],
                    ecog: ['4'],
                },
                formData: {
                    research_area: null,
                    name: ( this.task ? this.task.name : null ),
                    deadline: null,
                    requiring: null,
                    requiring_value: '2_m',
                    deadline_value: null,
                    note_1: null,
                    note_2: null,
                    special_task: null,
                    ecog: null,
                },
            }
        },
        components: {
            'datepicker': Datepicker,
        },
    }
</script>
