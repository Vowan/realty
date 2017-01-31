jQuery(function ($) {

    $("#shot_title").val(function (index, value) {
        return $("#rooms").val() + "- комнатная квартира по цене $" + $("#cost_US").val() + '.000';
    })

    $("#cost_US").on("change click", function (e) {
        var that = $(this);
        $('#priceDolError').text('');

        $("#shot_title").val(function (index, value) {
            return $("#rooms").val() + "- комнатная квартира по цене $" + that.val() + '.000';
        })
    });

    $("#rooms").on("change  click", function (e) {
        var that = $(this);
        $('#roomNError').text('');
        $("#shot_title").val(function (index, value) {
            return that.val() + "- комнатная квартира по цене $" + $("#cost_US").val() + '.000';
        })
    });




    /*********************************edit  form submit********************************************/
    $("#zag-edit-sell-prop").click(function (e) { 

        $("#edit-sell-form").trigger('submit.edit');
    })

    $('#edit-sell-form').on('submit.edit', function (e) {
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

   
        var formData = new FormData(this);



        //console.log($('#new-property-form input[type="file"]'))



        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_edit_sell_prop_ajax_action');
        formData.append('coming_edit_sell_nonce', ajax_edit_sell.edit_sell_nonce);
        formData.append('current_page', current_page);

        var msg_error = 'An error has occured. Please try again later.';
        var msg_timeout = 'The server is not responding';
        var message = '';

        $.ajax({
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: ajax_edit_sell.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {
                if (status === "timeout") {
                    alert(msg_timeout);
                } else {
                    alert(msg_error);
                }
            },
            success: function (response) {

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

    /********************************* form  unpublish submit********************************************/
    $("#zag-unpublish-sell-prop").click(function (e) { 


        $("#edit-sell-form").trigger('submit.unpublish');
    })

    $('#edit-sell-form').on('submit.unpublish', function (e) {
        e.preventDefault();


        var formData = new FormData();

        formData.append('post_id', $('#post_id').val());
        formData.append('action', 'zag_unpublish_sell_prop_ajax_action');
        formData.append('coming_unpublish_sell_nonce', ajax_edit_sell.edit_sell_nonce);


        var msg_error = 'An error has occured. Please try again later.';
        var msg_timeout = 'The server is not responding';
        var message = '';

        $.ajax({
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: ajax_edit_sell.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {
                if (status === "timeout") {
                    alert(msg_timeout);
                } else {
                    alert(msg_error);
                }
            },
            success: function (response) {

                // debugger
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



    /********************************* form  trash submit********************************************/
    $("#zag-delete-sell-prop").click(function (e) { 


        $("#edit-sell-form").trigger('submit.trash');
    })

    $('#edit-sell-form').on('submit.trash', function (e) {
        e.preventDefault();


        var formData = new FormData();

        formData.append('post_id', $('#post_id').val());
        formData.append('action', 'zag_trash_sell_prop_ajax_action');
        formData.append('coming_delete_sell_nonce', ajax_edit_sell.edit_sell_nonce);


        var msg_error = 'An error has occured. Please try again later.';
        var msg_timeout = 'The server is not responding';
        var message = '';

        $.ajax({
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: ajax_edit_sell.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {
                if (status === "timeout") {
                    alert(msg_timeout);
                } else {
                    alert(msg_error);
                }
            },
            success: function (response) {
                
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





