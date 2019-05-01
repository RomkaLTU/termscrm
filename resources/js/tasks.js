(function($){
    $(function(){
        const $params = $('.select2_task_params');

        $params.select2({
            placeholder: 'Pridėti parametrą',
            tags: true,
            createTag: function (params) {
                const term = $.trim(params.term);
                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term + ' (naujas)'
                };
            },
        });

        // insertinam nauja parametra i DB
        $params.on('select2:select', function(e){
            if ( typeof e.params.data.element === 'undefined' ) {
                $.post(window.API_DOMAIN + '/tasks/params', {
                    name: e.params.data.id
                });
            }
        });
    });
}(window.jQuery));
