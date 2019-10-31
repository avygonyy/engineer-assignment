"use strict";

$(function () {
    $('.subscribe-newsletter').on('submit', 'form', function () {
        let $form = $(this);
        let $submit = $form.find('button[type="submit"]');
        $submit.attr('disabled', true);

        subscribe($form)
            .then(response => {
                $(document).find('.flash-message').append(`
                    <p class="alert alert-success">${response.message} <span class="closebtn">&times;</span></p>
                `);
                $form[0].reset();
                $submit.attr('disabled', false);
            })
            .catch(error => {
                let errors = error.errors || error.message || "Unhandled Error";
                if (typeof errors == "string") {
                    $(document).find('.flash-message').append(`
                        <p class="alert alert-danger">${errors} <span class="closebtn">&times;</span></p>
                    `);
                } else {
                    let errorMessage = "";
                    for (let errtype in errors) {
                        errorMessage += errors[errtype].join("\r\n");
                        errorMessage += "\r\n";
                    }
                    $(document).find('.flash-message').append(`
                        <p class="alert alert-danger">${errorMessage} <span class="closebtn">&times;</span></p>
                    `);
                }

                $submit.attr('disabled', false);

            });
        return false;
    });
});

function subscribe($form) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: $form.attr('method') || 'POST',
            url: $form.attr('action'),
            data: $form.serializeArray(),
            dataType: 'json',
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                if (error.responseJSON.length) {
                    reject(error.responseJSON);
                } else if (error.responseText.length) {
                    reject(JSON.parse(error.responseText));
                }

                reject(error);
            }
        })
    });
}
