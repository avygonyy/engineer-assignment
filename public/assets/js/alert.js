"use strict";

$(function () {
    $(document).on('click', '.alert .closebtn', function () {
        $(this).parent().fadeOut(400, function () {
            $(this).remove();
        });
    });
});
