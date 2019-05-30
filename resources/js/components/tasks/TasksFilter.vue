<template>
    <form autocomplete="off" id="tasksFilterForm" class="kt-form kt-form--fit kt-margin-b-20">
        <div class="row kt-margin-b-20">
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                <label for="tyrimoSritis">Tyrimo sritys</label>
                <div class="input-group">
                    <select class="form-control" name="research_area_id" id="tyrimoSritis">
                        <option value="">Visos</option>
                        <option v-for="area in research_areas" :key="`area_${area.id}`" :value="area.id">
                            {{ area.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                <label>Užduočių datos:</label>
                <div class="input-daterange input-group">
                    <input type="text" autocomplete="off" class="form-control kt-input date-input" id="tasksFrom" name="start" placeholder="Nuo" data-col-index="5" />
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                    </div>
                    <input type="text" autocomplete="off" class="form-control kt-input date-input" id="tasksTo" name="end" placeholder="Iki" data-col-index="5" />
                </div>
            </div>
        </div>
        <div class="kt-separator kt-separator--md kt-separator--dashed"></div>
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-brand--icon" @click.prevent="filter" id="kt_search">
                    <span>
                        <i class="la la-search"></i>
                        <span>Filtruoti</span>
                    </span>
                </button>
                &nbsp;&nbsp;
                <button class="btn btn-secondary btn-secondary--icon" @click.prevent="clear" id="kt_reset">
                    <span>
                        <i class="la la-close"></i>
                        <span>Išvalyti</span>
                    </span>
                </button>
            </div>
        </div>
        <div v-if="supervisor" class="mt-4">
            <strong>Atsakingas asmuo:</strong> {{ supervisor.name }} ({{ supervisor.duties }}) <a :href="`mailto:${supervisor.email}`">{{ supervisor.email }}</a>
        </div>
        <div v-if="ra && !supervisor" class="mt-4">
            <strong>Atsakingas asmuo nepriskirtas. &nbsp; <a :href="`/contracts/${contract.id}/objects/${object.id}/edit`">Priskirti čia</a>.</strong>
        </div>
    </form>
</template>

<script>
    export default {
        name: 'tasks-filter',
        props: ['research_areas','supervisors','contract','object'],
        data(){
            return {
                dateFrom: null,
                dateTo: null,
                ra: false,
                supervisor: false,
            }
        },
        mounted(){
            $('.input-daterange').datepicker({
                todayHighlight: true,
                format:"yyyy-mm-dd",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>',
                },
            });
        },
        methods: {
            clear(){
                document.getElementById("save_completed").style.display = 'none';
                document.getElementById("print_selected").style.display = 'none';
                document.getElementById("tasksFilterForm").reset();
                this.filter();
            },
            filter(){
                const researchArea = document.getElementById('tyrimoSritis');
                const tasksFrom = document.getElementById('tasksFrom');
                const tasksTo = document.getElementById('tasksTo');

                const $table = $('#dtable');
                const $table2 = $('#dtable2');
                const model = $table.data('model');

                // Gaunam atsakinga asmeni
                if ( typeof this.supervisors[researchArea.value] !== "undefined" ) {
                    this.supervisor = this.supervisors[researchArea.value];
                } else {
                    this.supervisor = false;
                }

                this.ra = ( researchArea.value === "" ? false : researchArea.value );

                if ($.fn.DataTable.isDataTable('#dtable')) {
                    $table.DataTable().destroy();
                }

                if ($.fn.DataTable.isDataTable('#dtable2')) {
                    $table2.DataTable().destroy();
                }

                $('#dtable tbody').empty();
                $('#dtable2 tbody').empty();

                let columnDefs = [
                    {
                        'targets': 3,
                        'orderable': false,
                        'type':'html',
                        'render': function (data) {
                            if ( data ) {
                                const params_arr = data.split(', ');
                                let html = '';

                                params_arr.forEach((param) => {
                                    html += `<span class="kt-badge kt-badge--primary kt-badge--md kt-badge--inline kt-badge--pill mr-1">${param}</span>`;
                                });

                                return html;
                            } else {
                                return null;
                            }
                        }
                    },
                    {
                        'targets': -3,
                        'title': 'Pažymėti darbus',
                        'orderable': false,
                        'className': 'text-center',
                        'type':'html',
                        'render': function (data, type, row) {
                            let color = '';
                            switch (row.DT_RowData.researcharea) {
                                case 'orai':
                                    color = 'kt-checkbox--success';
                                    break;
                                case 'nuotekos':
                                    color = 'kt-checkbox--brand';
                                    break;
                                case 'geologija':
                                    color = 'kt-checkbox--warning';
                                    break;
                                case 'rasto-darbai':
                                    color = 'kt-checkbox--dark';
                                    break;
                                case 'kita':
                                    color = 'kt-checkbox--danger';
                                    break;
                            }
                            return `
                            <label class="kt-checkbox ${color}">
                                <input class="completed"
                                    type="checkbox"
                                    data-ra="${row.DT_RowData.researcharea}"
                                    name="completed[${row.DT_RowData.researcharea}][]"
                                    value="${row.DT_RowData.taskid}"> &nbsp;
                                <span></span>
                            </label>
                        `;
                        },
                    },
                    {
                        'targets': -2,
                        'title': 'Istorija',
                        'orderable': false,
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                            <button data-toggle="modal"
                                data-contractid="${row.DT_RowData.contractid}"
                                data-objectid="${row.DT_RowData.objectid}"
                                data-taskid="${row.DT_RowData.taskid}"
                                data-target="#tasks_history" class="btn btn-outline-brand btn-sm">
                                Peržiūreti
                            </button>
                        `;
                        },
                    },
                    {
                        'targets': -1,
                        'title': 'Veiksmai',
                        'orderable': false,
                        'className': 'nowrap',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                            <div class="d-flex">
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks/${row.DT_RowData.taskid}/edit" data-toggle="confirmation" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-edit"></i>
                                </a>
                                <div class="action-confirmation">
                                    <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md confirm_action">
                                        <i class="la la-trash"></i>
                                    </button>
                                    <div class="confirm-block">
                                        <form action="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks/${row.DT_RowData.taskid}" method="post">
                                            <input type="hidden" name="_token" value="${window.CSRF}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <div>
                                                <div class="d-flex">
                                                    <button type="submit" rel="tooltip" data-toggle="confirmation" class="btn btn-sm btn-danger mr-1">
                                                        Trinti
                                                    </button>
                                                    <button type="button" rel="tooltip" data-toggle="confirmation" class="btn btn-sm btn-clean close_confirmation">
                                                        Atšaukti
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                        }
                    },
                ];

                if ( researchArea.value === '5' || researchArea.value === '6' ) {
                    columnDefs.push({
                        'targets': 3,
                        'visible': false,
                    });
                }

                $table.DataTable({
                    ajax: {
                        url: `${model}/json`,
                        data: {
                            tasksFrom: tasksFrom.value,
                            tasksTo: tasksTo.value,
                            researchArea: researchArea.value,
                        }
                    },
                    'processing': true,
                    'serverSide': true,
                    'responsive': true,
                    'searching': true,
                    'deferRender': true,
                    'dom': `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    'lengthMenu': [5, 10, 25, 50],
                    'pageLength': 10,
                    'order': [],
                    'language': {
                        'lengthMenu': 'Rodyti _MENU_',
                    },
                    'rowCallback': function(row, data) {
                        if ( data.DT_RowData.special ) {
                            $(row).addClass('table-success');
                        }
                    },
                    'columnDefs': columnDefs,
                });

                if ( researchArea.value === '4'  ) {
                    $table2.show();
                    $table2.DataTable({
                        ajax: {
                            url: `${model}/json`,
                            data: {
                                tasksFrom: tasksFrom.value,
                                tasksTo: tasksTo.value,
                                researchArea: researchArea.value,
                                ecog: true,
                            }
                        },
                        'processing': true,
                        'serverSide': true,
                        'responsive': true,
                        'searching': true,
                        'deferRender': true,
                        'dom': `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                        'lengthMenu': [5, 10, 25, 50],
                        'pageLength': 10,
                        'order': [],
                        'language': {
                            'lengthMenu': 'Rodyti _MENU_',
                        },
                        'rowCallback': function(row, data) {
                            if ( data.DT_RowData.special ) {
                                $(row).addClass('table-success');
                            }
                        },
                        'columnDefs': columnDefs,
                    });
                } else {
                    $table2.hide();
                }
            },
        },
    }
</script>
