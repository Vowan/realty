jQuery(function ($) {

    $("#shot_title").val(function (index, value) {
        return "Куплю "+$("#rooms").val() + "- комнатную квартиру по цене $" + $("#cost_US").val() + '.000';
    })

    $("#cost_US").on("change click", function (e) {
        var that = $(this);
        $('#priceDolError').text('');

        $("#shot_title").val(function (index, value) {
            return "Куплю "+$("#rooms").val() + "- комнатную квартиру по цене $" + that.val() + '.000';
        })
    });

    $("#rooms").on("change  click", function (e) {
        var that = $(this);
        $('#roomNError').text('');
        $("#shot_title").val(function (index, value) {
            return "Куплю "+that.val() + "- комнатную квартиру по цене $" + $("#cost_US").val() + '.000';
        })
    });


    /*********************************New buy property form submit********************************************/
    $("#zag-new-prop").click(function (e) { 

        $("#buy-prop-form").trigger('submit')
    })

    $('#buy-prop-form').on('submit', function (e) {
        e.preventDefault();

        if ($('#user_first_name').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите Ваше имя' + "</p>");

            return false;
        }

        if ($('#user_tel').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите Ваш телефон' + "</p>");

            return false;
        }


        if ($('#user_email').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите Ваш правильный емейл' + "</p>");

            return false;
        }

        if ($('#user_agency').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите Ваш статус - хозяин, посредник или название агенства' + "</p>");

            return false;
        }

        if ($('#shot_title').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Краткое заглавие нельзя оставлять пустым' + "</p>");

            return false;
        }

        if ($('#liveSQ').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите жилую площадь' + "</p>");

            return false;
        }

        if ($('#totalSQ').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите общую площадь' + "</p>");

            return false;
        }

        if ($('#level').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Укажите этажность по схеме эт-эт' + "</p>");

            return false;
        }

        if ($('#locality').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'В выбранном  Вами адресе нет населенного пункта. В нашей системе он должен быть обязательно' + "</p>");

            return false;
        }

        if ($('#route').val() == '') {
            $('#body_error').html('');
            $('#row_error').css('display', 'block');
            $('#body_error').append("<p style='color: red;'>" +
                    'В выбранном  Вами адресе нет улицы. В нашей системе она должна быть обязательно' + "</p>");

            return false;
        }

        if ($('#cost_US').val() == '') {

            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Пожалуйста, укажите цену $ ' + "</p>");


            return false;
        }

        if ($('#rooms').val() == '') {
            $('#body_error').html('');
            $('#row_error').css('display', 'block');

            $('#body_error').append("<p style='color: red;'>" +
                    'Пожалуйста, укажите желаемое  количество комнат' + "</p>");

            return false;
        }



        var formData = new FormData(this);

        //console.log($('#new-property-form input[type="file"]'))


        var map_autocomplete = $("#autocomplete").val();

        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_new_buy_prop_ajax_action');
        formData.append('coming_new_buy_nonce', ajax_new_buy.new_buy_nonce);
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
            url: ajax_new_buy.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {
                if (status === "timeout") {
                    alert(msg_timeout);
                } else {
                    alert(msg_error);
                }
            },
            success: function (response) {
                //      console.log(response.data.ok);

                if ('ok' == response.data.ok) {

                    window.parent.location.reload();
                }

                if (response.data.error) {

                    $('#body_error').html('');
                    $('#row_error').css('display', 'block');

                    for (var form_error in response.data.error) {
                        $('#body_error').append("<p style='color: red;'>" + response.data.error[form_error] + "</p>");

                    }
                    //   console.log(response.data.error);
                }
            },
        });
    });
});


