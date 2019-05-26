<template>
    <form autocomplete="off" id="tasksFilterForm" class="kt-form kt-form--fit kt-margin-b-20">
        <div class="row kt-margin-b-20">
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
                <label for="region">Regionai</label>
                <div class="input-group">
                    <select class="form-control" name="research_area_id" id="region">
                        <option value="">Visi</option>
                        <option v-for="region in regions" :key="`region_${region.id}`" :value="region.id">
                            {{ region.name }}
                        </option>
                    </select>
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
    </form>
</template>

<script>
    export default {
        name: 'tasks-filter',
        props: ['research_areas','regions'],
        data(){
            return {
                dateFrom: null,
                dateTo: null,
                ra: false,
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
                document.getElementById("tasksFilterForm").reset();
                this.filter();
            },
            filter(){
                const researchArea = document.getElementById('tyrimoSritis');
                const tasksFrom = document.getElementById('tasksFrom');
                const tasksTo = document.getElementById('tasksTo');
                const region = document.getElementById('region');

                const $table = $('#dtable');
                const model = $table.data('model');

                this.ra = ( researchArea.value === "" ? false : researchArea.value );

                if ($.fn.DataTable.isDataTable('#dtable')) {
                    $table.DataTable().destroy();
                }

                $('#dtable tbody').empty();

                let columnDefs = [
                    {
                        'targets': 0,
                        'title': 'Objektas',
                        'orderable': false,
                        'className': '',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/edit">${data}</a>
                            `;
                        }
                    },
                    {
                        'targets': 3,
                        'title': 'Darbas',
                        'orderable': false,
                        'className': '',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks/${row.DT_RowData.taskid}/edit">${data}</a>
                            `;
                        }
                    },
                    {
                        'targets': -1,
                        'title': 'Veiksmai',
                        'orderable': false,
                        'className': 'text-center',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                                <label class="kt-checkbox">
                                    <input class="completed" type="checkbox" name="completed[]" value="${row.DT_RowData.taskid}"> &nbsp;
                                    <span></span>
                                </label>
                            `;
                        }
                    },
                ];

                if ( researchArea.value === '5' || researchArea.value === '6' ) {
                    columnDefs.push({
                        'targets': 2,
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
                            region: region.value,
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

                        if ( data.DT_RowData.late ) {
                            $(row).addClass('table-warning');
                        }
                    },
                    'columnDefs': columnDefs,
                });
            },
        },
    }
</script>
