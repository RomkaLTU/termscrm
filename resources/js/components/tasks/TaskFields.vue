<template>
    <div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="pavadinimas">Pavadinimas</label>
                <input type="text" class="form-control" id="pavadinimas" v-model="formData.name" name="name" placeholder="Pavadinimas" required>
            </div>
            <div class="col-lg-6">
                <label for="tyrimoSritys">Tyrimo sritis</label>
                <select class="form-control" v-model="formData.research_area" name="research_area_id" id="tyrimoSritys">
                    <option v-for="area in research_areas" :key="`area_${area.id}`" :value="area.id">
                        {{ area.name }}
                    </option>
                </select>
            </div>
        </div>
        <template v-if="formData.research_area !== ''">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label class="kt-checkbox mb-0 mr-3" v-show="fields.special_task.some((item) => Number(item) === Number(formData.research_area))">
                        <input type="hidden" name="special_task" value="0" checked>
                        <input type="checkbox" name="special_task" v-model="formData.special_task" value="1"> Spec. užduotis
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label for="kt_select2_11">Parametrai</label>
                    <select class="form-control m-select2 select2_task_params" multiple name="task_params">
                        <option></option>
                        <option v-for="param in task_params" :key="`param_${param.id}`" :value="param.id">{{ param.name }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Atlikti iki</label>
                    <div class="d-flex align-items-center mt-1">
                        <div class="d-flex">
                            <div class="d-flex align-items-center mr-5">
                                <div>
                                    <datepicker
                                        v-model="formData.due_date"
                                        :monday-first="true"
                                        input-class="form-control"
                                        format="yyyy-MM-dd"
                                        :language="lt"
                                        v-on:selected="dueDateChange"
                                        placeholder="Atlikti iki..."
                                        name="due_date"></datepicker>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div>
                                    <select class="form-control" v-model="formData.requiring_int" @change="requiringIntChange" name="requiring_int">
                                        <option value="0">Reguliariai</option>
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
                    <label for="notes_1">Pastabos 1</label>
                    <input type="text" class="form-control" id="notes_1" v-model="formData.notes_1" name="notes_1" placeholder="Pastabos 1">
                </div>
                <div class="col-lg-6">
                    <label for="notes_2">Pastabos 2</label>
                    <input type="text" class="form-control" id="notes_2" v-model="formData.notes_2" name="notes_2" placeholder="Pastabos 2">
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
        </template>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker'
    import {en, lt} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'task-fields',
        props: ['obj','research_areas','research_area','contract','documents','task','task_params'],
        data() {
            return {
                en: en,
                lt: lt,
                fields: {
                    special_task: ['1','4'],
                    ecog: ['4'],
                },
                formData: {
                    research_area: ( this.research_area ? this.research_area : '1' ),
                    name: ( this.task ? this.task.name : null ),
                    requiring_int: ( this.task ? this.task.requiring_int : '' ),
                    due_date: ( this.task ? this.task.due_date : '' ),
                    notes_1: ( this.task ? this.task.notes_1 : '' ),
                    notes_2: ( this.task ? this.task.notes_2 : '' ),
                    special_task: ( this.task ? this.task.special_task : '' ),
                    ecog: ( this.task ? this.task.ecog : '' ),
                },
            }
        },
        components: {
            'datepicker': Datepicker,
        },
        methods: {
            requiringIntChange(){
                this.formData.due_date = null;
            },
            dueDateChange(){
                this.formData.requiring_int = '';
            },
        },
    }
</script>
