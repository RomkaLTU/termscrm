<template>
    <div>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="pavadinimas">Pavadinimas</label>
                <input type="text" class="form-control" id="pavadinimas" v-model="formData.name" name="name" placeholder="Pavadinimas">
            </div>
            <div class="col-lg-6">
                <label for="tyrimoSritys">Tyrimo sritis</label>
                <select class="form-control" id="tyrimoSritys" >
                    <option>Pasirinkite</option>
                    <option v-for="area in research_areas" :key="`area_${area.id}`" :value="area.id">
                        {{ area.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>Atlikti iki</label>
                <div class="d-flex align-items-center mt-1">
                    <div class="d-flex">
                        <div class="d-flex align-items-center mr-5">
                            <label class="kt-radio mb-0 mr-3">
                                <input type="radio" name="validity" v-model="formData.deadline" value="todate"> Pasirinkta data:
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

                        </div>
                    </div>
                </div>
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
                formData: {
                    name: ( this.task ? this.task.name : null ),
                    deadline: null,
                },
            }
        },
        components: {
            'datepicker': Datepicker,
        },
    }
</script>
