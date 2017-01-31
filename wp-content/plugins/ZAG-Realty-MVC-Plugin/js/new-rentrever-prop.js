jQuery(function ($) {



    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        startDate: '-3d',
        language: 'ru'
    });


    if ($('#daily').is(':checked')) {
        $('#time span[data-id="time_int"]').each(function (index) {
            $(this).text('день');
        });
    }

    if ($('#long').is(':checked')) {
        $('#time span[data-id="time_int"]').each(function (index) {
            $(this).text('месяц');
        });
    }

    $('input[type="radio"]').on('change', function (e) {
        if ($('#daily').is(':checked')) {
            $('#time span[data-id="time_int"]').each(function (index) {
                $(this).text('день');
            });
        }

        if ($('#long').is(':checked')) {
            $('#time span[data-id="time_int"]').each(function (index) {
                $(this).text('месяц');
            });
        }
    });



    /*********************************New  form submit********************************************/
    $("#zag-new-rentrever-prop").click(function (e) { 


        // check if the input is valid
        $("#new-rentrever-form").validate({
            rules: {
                user_first_name: {
                    required: true,
                    maxWords: 1,
                },
                user_last_name: {
                    maxWords: 1,
                },
                user_email: {
                    required: true,
                    email: true
                },
                user_tel: {
                    required: true,
                    pattern: '\\d+',
                    maxWords: 1,
                },
                shot_title: {
                    required: true,
                },
            },
            messages: {
                user_first_name: {
                    required: 'Обязательно укажите имя контактного лица',
                    maxWords: 'Имя должно состоять из одного  слова',
                },
                user_last_name: {
                    maxWords: 'Фамилия должно состоять из одного  слова',
                },
                user_email: {
                    required: 'Пожалуйста, введите Ваш email',
                    email: 'email должен иметь правильный формат qqq@qqq.qqq',
                },
                user_tel: {
                    required: 'Пожалуйста, введите Ваш телефон',
                    pattern: 'Номер телефона должен состоять из цифр',
                    maxWords: 'Введите номер телефона одним словом без пробелов',
                },
                shot_title: {
                    required: 'Необходимо заполнить титульное заглавие',
                },
            }
        });

        $("#new-rentrever-form").trigger('submit');
    })

    $('#new-rentrever-form').on('submit', function (e) {
        e.preventDefault();

        if ($('#locality').val() == '') {
            $('#addr_error').text('В выбранном  Вами адресе нет населенного пункта. В нашей системе он должен быть обязательно');
            return false;
        }

        if ($('#route').val() == '') {
            $('#addr_error').text('В выбранном  Вами адресе нет улицы. В нашей системе она должна быть обязательно');
            return false;
        }

        if ($('#property_price').val() == '') {
            $('#priceDolError').text('Пожалуйста, укажите цену');
            return false;
        }

        if ($('#property_roomN').val() == '') {
            $('#roomNError').text('Пожалуйста, укажите желаемое  количество комнат');
            return false;
        }

        if (!$(this).valid())
            return false;

        var formData = new FormData(this);


        var map_autocomplete = $("#autocomplete").val();

        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_new_rentrever_prop_ajax_action');
        formData.append('my_nonce', ajax_object.ajax_nonce);
        formData.append('map_autocomplete', map_autocomplete);
        formData.append('current_page', current_page);

        var msg_error = 'An error has occured. Please try again later.';
        var msg_timeout = 'The server is not responding';
        var message = '';

        $.ajax({
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: ajax_project.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {
                if (status === "timeout") {
                    alert(msg_timeout);
                } else {
                    alert(msg_error);
                }
            },
            success: function (response) {
                if (response.data) {

                    window.parent.location.reload();
                }

                if (response.data.error) {

                    $('#profile-errors').html('');

                    for (var form_error in response.data.error) {
                        $('#profile-errors').append("<p style='color: red;'>" + response.data.error[form_error] + "</p>");

                    }
                    //   console.log(response.data.error);
                }
            },
        });
    });

    var time_per;

    $('#shot_title').val(function (index, value) {




        time_per = 'посуточно' == $('input[name=time_period]:checked').val() ? 'в день' : 'в месяц';


        return 'Сниму  ' + $('#rooms').val() + ' - комнатную квартиру.  $ ' + $('#cost_US').val() + ' '+ time_per
    });

    $('#rooms').on('click change', function (e) {

        var that = $(this);
        time_per = 'посуточно' == $('input[name=time_period]:checked').val() ? 'в день' : 'в месяц';


        $('#shot_title').val(function (index, value) {
            return 'Сниму  ' + that.val() + ' - комнатную квартиру.  $ ' + $('#cost_US').val() + ' '+  time_per
        });
    });

    $('#cost_US').on('click change', function (e) {

        var that = $(this);
        time_per = 'посуточно' == $('input[name=time_period]:checked').val() ? 'в день' : 'в месяц';


        $('#shot_title').val(function (index, value) {
            return 'Сниму  ' + $('#rooms').val() + ' - комнатную квартиру.  $ ' + that.val() +' '+ time_per
        });
    });

});





