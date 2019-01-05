function getFormData(form) {
    var data = {};
    $.each(form.find('.field'), function () {
        data[$(this).attr('name')] = $(this).val();
    });

    return data;
}

var formSend = (function () {
    var formData = {};
    var ajaxAction = "";
    var form = {};

    var postSend = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var request = $.ajax({url: ajaxAction, data: formData, type: 'post', dataType: 'json'});

        request.done(function (response) {
            if (response.error != 0) {
                var errors = response.original.errors;
                $.each(errors, function(key, value){
                    $('#' + key).next().show().find('strong').html(value);
                })
            } else {
                window.location = '/catalog';
            }
        });
    };
    return {
        send: function (that, event) {
            event.preventDefault();
            form = $(that).parents('form');
            formData = getFormData(form);
            ajaxAction = form.attr('action');
            form.find('.invalid-feedback').hide();
            postSend();

        }
    }
})()

