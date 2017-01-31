jQuery(function ($) {

    $("#shot_title").val(function (index, value) {
        return "Продается "+ $("#rooms").val() + "- комнатная квартира по цене $" + $("#cost_US").val() + '.000';
    })

    $("#cost_US").on("change click", function (e) {
        var that = $(this);
        $('#priceDolError').text('');

        $("#shot_title").val(function (index, value) {
            return "Продается "+  $("#rooms").val() + "- комнатная квартира по цене $" + that.val() + '.000';
        })
    });

    $("#rooms").on("change  click", function (e) {
        var that = $(this);
        $('#roomNError').text('');
        $("#shot_title").val(function (index, value) {
            return "Продается "+ that.val() + "- комнатная квартира по цене $" + $("#cost_US").val() + '.000';
        })
    });



    function addPanel(index, room) {

        var newProject = $("#room-draft").clone();
        newProject.attr('id', 'room-' + index);
        newProject.find('input[type="file"]').attr('name', 'room[' + index + ']');
        newProject.find('select').attr('name', 'select[' + index + ']');



        newProject.find('.preview').attr('id', 'prev-' + index);

        newProject.find('.btn-danger').attr('data-id', '' + index);

        newProject.find('#roomSQ').attr('id', 'roomSQ-' + index).attr('name', 'roomSQ[' + index + ']');

        newProject.css('display', 'block');

        return  newProject;
    }


    var active;
    /*********************************************************One************************************************/
    var num_imgs = 0;

    $("#sellRoomButton").click(function (e) { 


        var prLength = $("#sec-rooms .zag-project").length;


        $("#sec-rooms").append(function (index, html) {
            return addPanel(prLength + 2);
        })


    });

    $("#all-rooms").on("click", "button.btn-danger", function (e) {


        var delet_index = $("#all-rooms button.btn-danger").index(e.target);

        $("#room-" + delet_index).remove();

        $('#one-room-slider .carousel-inner').find('div[data-id = "' + delet_index + '"]').remove();
        $('#one-room-slider .carousel-indicators').find('li[data-id = "' + delet_index + '"]').remove();

        $('#one-room-slider .carousel-inner').find('div').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        $('#one-room-slider .carousel-indicators').find('li').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        num_imgs--;


        $("#all-rooms .zag-project").each(function (index) {

            var panel_elem = $(this);

            panel_elem.attr('id', 'room-' + index);
            panel_elem.find('input[type="file"]').attr('name', 'room[' + index + ']');

            panel_elem.find('.preview').attr('id', 'prev-' + index);

            panel_elem.find('.btn-danger ').attr('data-id', '' + index);

            panel_elem.find('select').attr('name', 'select[' + index + ']');

            panel_elem.find('input[type="number"]').attr('id', 'roomSQ-' + index).attr('name', 'roomSQ[' + index + ']');




        });




    })

    $("#all-rooms").on("change", "input[type='file']", function (e) {




        if (typeof (FileReader) != "undefined") {



            if (num_imgs < 0)
                num_imgs = 0;

            var input_index = $("#all-rooms input[type='file']").index(e.target);

            var dvPreview = $("#prev-" + input_index);




            if (dvPreview.html()) {

                dvPreview.find('img').each(function (index) {

                    var img_id = $(this).data('id');

                    $('#one-room-slider .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
                    $('#one-room-slider .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();

                    num_imgs--;
                })

                $('#one-room-slider .carousel-inner').find('div').each(function (index) {

                    $(this).removeClass('active');

                    if (0 == index) {
                        $(this).addClass('active');
                    }

                    $(this).attr("data-id", index);
                });

                $('#one-room-slider .carousel-indicators').find('li').each(function (index) {

                    $(this).removeClass('active');

                    if (0 == index) {
                        $(this).addClass('active');
                    }

                    $(this).attr("data-id", index);
                });

            }

            dvPreview.html("");


            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("style", "height:40px; width: 40px");
                        img.attr("src", e.target.result);
                        img.attr("data-id", num_imgs);

                        dvPreview.append(img);
                        if (0 == num_imgs) {
                            active = 'active';
                        } else {
                            active = '';
                        }


                        $('#one-room-slider .carousel-inner').append('<div data-id="' + num_imgs + '" class="item ' + active + '"><img src="' + e.target.result + '" alt="..."> </div>')
                        $('#one-room-slider .carousel-indicators').append('<li data-id="' + num_imgs + '" data-target="#prop-slider" data-slide-to="' + num_imgs + '" class="' + active + '"></li>')

                        num_imgs++;
                        // console.log(car_items);

                        $('#one-room-slider').data('bs.carousel', '');
                        $('#one-room-slider').carousel();

                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    alert(file[0].name + " is not a valid image file.");
                    dvPreview.html("");
                    return false;
                }
            });
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }



    });



    /*********************************New buy property form submit********************************************/
    $("#zag-new-sell-prop").click(function (e) { 


       
        $("#new-sell-property-form").trigger('submit');
    })

    $('#new-sell-property-form').on('submit', function (e) {
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

        $('#new-sell-property-form input[type="file"]').each(function (index) {
            var file_data = this.files; // for multiple files


            for (var i = 0; i < file_data.length; i++) {
                formData.append("file[" + index + "][" + i + "]", file_data[i]);
            }

        });

        //console.log($('#new-property-form input[type="file"]'))


        var map_autocomplete = $("#autocomplete").val();

        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_new_sell_prop_ajax_action');
        formData.append('coming_new_sell_nonce', ajax_new_sell.new_sell_nonce);
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
            url: ajax_new_sell.ajax_url,
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





