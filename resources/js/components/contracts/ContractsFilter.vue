<template>
    <form autocomplete="off" id="contractFilterForm" class="kt-form kt-form--fit kt-margin-b-20">
        <div class="row kt-margin-b-20">
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                <label>Sutarčių datos:</label>
                <div class="input-daterange input-group">
                    <input type="text" autocomplete="off" class="form-control kt-input date-input" id="contractsFrom" name="start" placeholder="Nuo" data-col-index="5" />
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                    </div>
                    <input type="text" autocomplete="off" class="form-control kt-input date-input" id="contractsTo" name="end" placeholder="Iki" data-col-index="5" />
                </div>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                <label>Sąskaitų apmokėjimas:</label>
                <div class="input-daterange input-group">
                    <input type="text" autocomplete="off" class="form-control kt-input" name="start" id="contractsUnpaidFrom" placeholder="Nuo" data-col-index="5" />
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                    </div>
                    <input type="text" autocomplete="off" class="form-control kt-input" name="end" id="contractsUnpaidTo" placeholder="Iki" data-col-index="5" />
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
        name: 'contracts-filter',
        data(){
            return {
                dateFrom: null,
                dateTo: null,
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
                document.getElementById("contractFilterForm").reset();
                this.filter();
            },
            filter(){
                const contractsFrom = document.getElementById('contractsFrom');
                const contractsTo = document.getElementById('contractsTo');
                const contractsUnpaidFrom = document.getElementById('contractsUnpaidFrom');
                const contractsUnpaidTo = document.getElementById('contractsUnpaidTo');

                const $table = $('#dtable');
                const model = $table.data('model');

                if ($.fn.DataTable.isDataTable('#dtable')) {
                    $table.DataTable().destroy();
                }

                $('#dtable tbody').empty();

                $table.DataTable({
                    ajax: {
                        url: `${model}/json`,
                        data: {
                            contractsFrom: contractsFrom.value,
                            contractsTo: contractsTo.value,
                            contractsUnpaidFrom: contractsUnpaidFrom.value,
                            contractsUnpaidTo: contractsUnpaidTo.value,
                        }
                    },
                    'scrollX': true,
                    searching: true,
                    deferRender: true,
                    dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 10,
                    order: [],
                    language: {
                        'lengthMenu': 'Rodyti _MENU_',
                    },
                    rowCallback: function(row, data) {
                        if ( data.DT_RowData.late ) {
                            $(row).addClass('table-warning');
                        }
                    },
                    columnDefs: [
                        {
                            targets: -1,
                            title: 'Veiksmai',
                            orderable: false,
                            className: 'nowrap',
                            'type':'html',
                            'render': function (data, type, row) {

                                let edit_action_html = '';
                                let delete_action_html = '';

                                if ( window.PERMISSIONS.includes('manage_contracts') ) {
                                    edit_action_html += `
                                    <a href="/${model}/${row.DT_RowData.rowid}/edit" data-toggle="confirmation" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                        <i class="la la-edit"></i>
                                    </a>
                                    `;

                                    delete_action_html += `
                                    <div class="action-confirmation">
                                        <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md confirm_action">
                                            <i class="la la-trash"></i>
                                        </button>
                                        <div class="confirm-block">
                                            <form action="contracts/${row.DT_RowData.rowid}" method="post">
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
                                    `;
                                }

                                return `
                                    <div class="d-flex">
                                        <a href="/${model}/${row.DT_RowData.rowid}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-eye"></i>
                                        </a>
                                        ${edit_action_html}
                                        ${delete_action_html}
                                    </div>
                                `;
                            }
                        },
                    ],
                    'processing': true,
                    'serverSide': true,
                });

                if ( !window.PERMISSIONS.includes('view_invoices') ) {
                    $table.DataTable().column(-2).visible(false);
                }
            },
        },
    }
</script>
