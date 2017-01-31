jQuery(function ($) {





    /********************************* form  edit submit********************************************/
    $("#zag-edit-rentlong-prop").click(function (e) { 


        // check if the input is valid
        $("#edit-longrent-form").validate({
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

        $("#edit-longrent-form").trigger('submit.edit');
    })

    $('#edit-longrent-form').on('submit.edit', function (e) {
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



        //console.log($('#new-property-form input[type="file"]'))




        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_edit_longrent_prop_ajax_action');
        formData.append('my_nonce', ajax_object.ajax_nonce);

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




    $('#rooms').on('click change', function (e) {

        var that = $(this);

        $('#shot_title').val(function (index, value) {
            return that.val() + ' - комнатная квартира.  $' + $('#cost_US').val() + ' в месяц'
        });
    });

    $('#cost_US').on('click change', function (e) {

        var that = $(this);

        $('#shot_title').val(function (index, value) {
            return $('#rooms').val() + ' - комнатная квартира.  $' + that.val() + ' в месяц'
        });
    });

    /********************************* form  unpublish submit********************************************/
    $("#zag-unpublish-rentlong-prop").click(function (e) { 


        $("#edit-longrent-form").trigger('submit.unpublish');
    })

    $('#edit-longrent-form').on('submit.unpublish', function (e) {
        e.preventDefault();


        var formData = new FormData();

        formData.append('post_id', $('#post_id').val());
        formData.append('action', 'zag_unpublish_longrent_prop_ajax_action');
        formData.append('my_nonce', ajax_object.ajax_nonce);


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
    
    

  /********************************* form  trash submit********************************************/
    $("#zag-delete-rentlong-prop").click(function (e) { 


        $("#edit-longrent-form").trigger('submit.trash');
    })

    $('#edit-longrent-form').on('submit.trash', function (e) {
        e.preventDefault();


        var formData = new FormData();

        formData.append('post_id', $('#post_id').val());
        formData.append('action', 'zag_trash_longrent_prop_ajax_action');
        formData.append('my_nonce', ajax_object.ajax_nonce);


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


});





