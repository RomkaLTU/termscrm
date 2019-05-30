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
                    <label for="task_params">Parametrai</label>
                    <select id="task_params" class="form-control m-select2 select2_task_params" multiple name="task_params[]">
                        <option></option>
                        <option
                            v-for="param in task_params"
                            :selected="task_params_selected.some( (id) => id === param.id )"
                            :key="`param_${param.id}`"
                            :value="param.id">{{ param.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label for="task_params_groups">Parametų grupės</label>
                    <div class="d-flex">
                        <select id="task_params_groups" class="form-control m-select2 select2_task_params_groups" multiple name="task_params_groups[]">
                            <option></option>
                            <option
                                v-for="params_group in task_params_groups_values"
                                :key="`param_${params_group.id}`"
                                :selected="task_params_groups_selected.some( (id) => id === params_group.id )"
                                :value="params_group.id">
                                {{ params_group.id }} - {{ params_group.taskparams.map(function(o) { return o["name"]; }).join(', ') }}
                            </option>
                        </select>
                        <button type="button" class="btn btn-outline-hover-success btn-elevate btn-pill d-flex ml-2" data-toggle="modal" data-target="#task_params_groups_modal">
                            <i class="flaticon-plus"></i>
                            Pridėti
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Atlikti iki</label>
                    <div class="d-flex align-items-center mt-1">
                        <div class="d-flex w-100">
                            <div class="d-flex align-items-center mr-2" style="flex:1">
                                <div class="w-100">
                                    <datepicker
                                        v-model="formData.due_date"
                                        :monday-first="true"
                                        input-class="form-control due w-100"
                                        format="yyyy-MM-dd"
                                        :language="lt"
                                        :clear-button="true"
                                        :typeable="true"
                                        :bootstrap-styling="true"
                                        v-on:selected="dueDateChange"
                                        placeholder="Atlikti iki..."
                                        name="due_date"></datepicker>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="flex:1">
                                <div class="w-100 d-flex flex-column-reverse">
                                    <input type="hidden" name="requiring_int" value="">
                                    <select id="requiring_int" class="select2 due w-100" v-model="formData.requiring_int" name="requiring_int">
                                        <option>2k. / mėn.</option>
                                        <option>1k. / mėn.</option>
                                        <option>1k. / ketv.</option>
                                        <option>2k. / met.</option>
                                        <option>1k. / met.</option>
                                        <option>Kita</option>
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
                        <input type="hidden" name="ecog" value="0" checked>
                        <input type="checkbox" name="ecog" v-model="formData.ecog" value="1"> Ekogeologinis
                        <span></span>
                    </label>
                </div>
            </div>
        </template>

        <div class="modal fade" id="task_params_groups_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Parametrų grupės</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="d-flex flex-column">
                                    <label for="task_params_group_items" class="form-control-label">Parametrai:</label>
                                    <div class="d-flex">
                                        <div class="w-100">
                                            <select id="task_params_group_items" class="form-control m-select2 select2_task_params" multiple style="width:100%">
                                                <option></option>
                                                <option
                                                    v-for="param in task_params"
                                                    :key="`param_${param.id}`"
                                                    :value="param.id">{{ param.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-outline-hover-success btn-elevate btn-pill d-flex ml-2" @click.prevent="createGroup" style="min-width: 138px;">
                                            <i class="flaticon-plus"></i>
                                            Sukurti grupę
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="param_groups">
                            <div class="col">
                                <div v-for="(params,group) in param_groups" :key="`group_${group}`" class="mb-2">
                                    <i class="far fa-trash-alt" @click="deleteGroup(group)"></i> &nbsp;
                                    <strong>{{ group }}</strong> -
                                    <span
                                        v-for="param in params"
                                        :key="param.id"
                                        class="kt-badge kt-badge--primary kt-badge--md kt-badge--inline kt-badge--pill mr-1">{{ param.name }}</span>
                                </div>
                            </div>
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
        props: [
            'obj',
            'research_areas',
            'research_area',
            'contract',
            'documents',
            'task',
            'task_params',
            'task_params_selected',
            'task_params_groups',
            'task_params_groups_selected',
        ],
        data() {
            return {
                en: en,
                lt: lt,
                fields: {
                    special_task: ['1','4'],
                    ecog: ['4'],
                },
                param_groups: false,
                task_params_groups_values: [],
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
        mounted() {
            this.getParamGroups();

            $('#requiring_int').on('select2:select', () => {
                // this.formData.due_date = null;
            });

            this.task_params_groups_values = this.task_params_groups;
        },
        methods: {
            dueDateChange(){

            },
            getParamGroups() {
                this.$http.get('tasks/paramgroup').then((response) => {
                    this.param_groups = response.data;
                });
            },
            createGroup() {
                const $task_params_group_items = $(task_params_group_items);

                if ( $.trim($task_params_group_items.val()).length === 0 ) {
                    toastr.error("Pasirinkite bent 1 parametrą");
                    return;
                }

                this.$http.post(`tasks/paramgroups`, {
                    task_params: $task_params_group_items.val(),
                    // user_id: window.USER_ID,
                }).then( () => {
                    toastr.success("Grupė sukurta");
                    this.getParamGroups();

                    this.$http.get('tasks/paramgroupsall').then((response) => {
                        this.task_params_groups_values = response.data;
                    });

                } );
            },
            deleteGroup(group_id) {
                this.$http.delete(`tasks/paramgroups/${group_id}`).then(() => {
                    toastr.success("Grupė ištrinta");
                    this.getParamGroups();
                });
            },
        },
    }
</script>
