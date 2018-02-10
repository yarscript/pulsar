// Image Manager
$(document).on('click', 'a[data-toggle=\'image\']', function (e) {
    var $element = $(this);
    var $popover = $element.data('bs.popover'); // element has bs popover?

    e.preventDefault();

    $('a[data-toggle="image"]').popover('destroy');

    if ($popover) {
        return;
    }

    $element.popover({
        html: true,
        placement: 'right',
        trigger: 'manual',
        content: function () {
            return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
        }
    });

    $element.popover('show');

    $('#button-image').on('click', function () {
        var $button = $(this);
        var $icon = $button.find('> i');

        $('#modal-image').remove();

        $.ajax({
            url: 'admin/filemanager?token=' + getURLVar('token') + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
            dataType: 'html',
            beforeSend: function () {
                $button.prop('disabled', true);
                if ($icon.length) {
                    $icon.attr('class', 'fa fa-circle-o-notch fa-spin');
                }
            },
            complete: function () {
                $button.prop('disabled', false);
                if ($icon.length) {
                    $icon.attr('class', 'fa fa-pencil');
                }
            },
            success: function (html) {
                $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                $('#modal-image').modal('show');
            }
        });

        $element.popover('destroy');
    });

    $('#button-clear').on('click', function () {
        $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));

        $element.parent().find('input').val('');

        $element.popover('destroy');
    });
});

function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}
