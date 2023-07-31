
    $(function() {
        $('button[data-confirm]').click(function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.preventDefault();
            }
        });
    });

