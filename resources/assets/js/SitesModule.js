require('./core/Forms');
require('./AddGroupItem');
require('./core/PageBuilder');
require('./components/AutoEditor');

$('.show').on('click', function () {
    $(this).find('.arrow').toggleClass('active');
    $(this).closest('.site').find('.additional-structure').eq(0).slideToggle('fast');
});

$(".change-visibility").click(function (e) {
    e.preventDefault();
    const object = $(this);
    $.ajax({
        url: object.attr('href'),
        method: "POST",
        data: {_token: $('meta[name=csrf-token]').attr('content')},
        success: function (data) {
            if (data.status) {
                object.find('i')[0].classList = 'mdi mdi-checkbox-marked-circle active';
            } else {
                object.find('i')[0].classList = 'mdi mdi-close-circle inactive';
            }
        },
        error: function () {
            Swal.fire('Wystąpił błąd!', 'Wystąpił błąd po stronie serwera', 'error');
        }
    })
});

$(".content-group-items-sortable").sortable();

$(".save-content-group-items-order").click(function () {
    const object = $(this);

    if (object.data('ajax')) return false;

    object.data('ajax', true);
    object.button('loading');

    $.ajax({
        url: object.data('url'),
        method: "POST",
        data: {
            _token: $("meta[name=csrf-token]").attr('content'),
            orders: prepareOrderContent()
        },
        success: function () {
            Swal.fire("Sukces", "Zmiany zostały pomyślnie zapisane", "success")
        },
        error: function() {
            Swal.fire("Błąd", "Wystąpił błąd systemu", "error");
        },
        complete: function () {
            object.data('ajax', false);
            object.button('reset');
        }
    });
});

function prepareOrderContent() {
    let orders = {};

    $(".content-group-item-order").each(function (index, item) {
        orders[$(item).data('name')] = index + 1;
    });

    return orders;
}

$('select#lang-options').change(function () {
    $(this).closest('form').submit();
});

$('a.add-translation-btn').click(function (e) {
    e.preventDefault();
    const btn = $(this);

    $.ajax({
        url: $(this).attr('href'),
        method: "GET",
        success: function (data) {
            if (data.status === 'success') {
                Swal.fire({
                    type: 'info',
                    title: 'Wybierz nową wersje językową strony',
                    input: 'select',
                    inputOptions: data.payload,
                    confirmButtonText: 'Dodaj',
                    showCancelButton: true,
                    cancelButtonText: 'Anuluj',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: btn.data('clone-route'),
                            method: 'POST',
                            data: {
                                _token: $("meta[name=csrf-token]").attr('content'),
                                language_short_name: result.value
                            },
                            success: function (data) {
                                Swal.fire("Udało się!", "Przejdź do nowej wersji językowej strony", "success").then(() => {
                                    window.location.replace(data.payload);
                                });
                            },
                            error: function () {
                                Swal.fire("Błąd", "Wystąpił błąd systemu", "error");
                            }
                        })
                    }
                })
            }
        },
        error: function() {
            Swal.fire("Błąd", "Wystąpił błąd systemu", "error");
        }
    });
});
