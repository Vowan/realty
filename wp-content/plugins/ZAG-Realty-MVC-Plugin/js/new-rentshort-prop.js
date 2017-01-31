jQuery(function ($) {

   


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

    $("#rentshortRoomButton").click(function (e) { 


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
    $("#zag-new-rentshort-prop").click(function (e) { 


        // check if the input is valid
        $("#new-shortrent-form").validate({
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

        $("#new-shortrent-form").trigger('submit');
    })

    $('#new-shortrent-form').on('submit', function (e) {
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

        $('#new-shortrent-form input[type="file"]').each(function (index) {
            var file_data = this.files; // for multiple files


            for (var i = 0; i < file_data.length; i++) {
                formData.append("file[" + index + "][" + i + "]", file_data[i]);
            }

        });

        //console.log($('#new-property-form input[type="file"]'))


        var map_autocomplete = $("#autocomplete").val();

        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_new_shortrent_prop_ajax_action');
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
});





