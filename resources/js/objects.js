(function($){
    const axios = require('./http');

    $(function(){

        const $table = $('#dtable');
        const model = $table.data('model');
        const $save_visited = $('#save_visited');
        const $visited_count = $('#visited_count');
        let checkedVisits = [];
        let contractid = false;

        $(document).on('change','.visited',function(){
            if ( this.checked ) {
                checkedVisits.push(this.value);
            } else {
                checkedVisits = _.without(checkedVisits, this.value);
            }

            $visited_count.html(checkedVisits.length);
            contractid = $(this).data('contractid');

            if ( checkedVisits.length ) {
                $save_visited.css('display','inline-block');
            } else {
                $save_visited.css('display','none');
            }
        });

        $save_visited.on('click',function(){
            axios.post(`visits`, {
                checked: checkedVisits,
                contractid: contractid,
                user_id: window.USER_ID,
            }).then(() => {
                window.toastr.success('Apsilankymai išsaugoti');
                $('.visited').prop('checked', false);
                checkedVisits = [];
                $save_visited.css('display','none');
            });
        });

        if ( $table.length ) {
            $table.DataTable({
                responsive: true,
                searching: true,
                dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                order: [],
                language: {
                    'lengthMenu': 'Rodyti _MENU_',
                },
                columnDefs: [
                    {
                        targets: -3,
                        title: 'Pažymėti aplankytus',
                        orderable: false,
                        className: 'text-center',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                            <label class="kt-checkbox">
                                <input class="visited" type="checkbox" name="visits[]" data-contractid="${row.DT_RowData.contractid}" value="${row.DT_RowData.objectid}"> &nbsp;
                                <span></span>
                            </label>
                        `;
                        },
                    },
                    {
                        targets: -2,
                        title: 'Istorija',
                        orderable: false,
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                            <button data-toggle="modal" data-contractid="${row.DT_RowData.contractid}" data-objectid="${row.DT_RowData.objectid}" data-target="#visit_history" class="btn btn-outline-brand btn-sm">
                                Peržiūreti
                            </button>
                        `;
                        },
                    },
                    {
                        targets: -1,
                        title: 'Veiksmai',
                        orderable: false,
                        className: 'nowrap',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                            <div class="d-flex">
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Užduotys">
                                    <i class="la la-list-alt"></i>
                                </a>
                                <a href="/contracts/${row.DT_RowData.contractid}/edit" data-toggle="confirmation" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-edit"></i>
                                </a>
                                <div class="action-confirmation">
                                    <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md confirm_action">
                                        <i class="la la-trash"></i>
                                    </button>
                                    <div class="confirm-block">
                                        <form action="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}" method="post">
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
                ],
                'processing': true,
                'serverSide': true,
                'ajax': `${model}/json`,
            });
        }

    })
}(window.jQuery));
