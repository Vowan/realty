// navigation slide-in



jQuery(function ($) {

    $("#spinner").bind("ajaxSend", function () {
        $(this).show();
    }).bind("ajaxStop", function () {
        $(this).hide();
    }).bind("ajaxError", function () {
        $(this).hide();
    });

    $(window).load(function () {
        $('.nav_slide_button').click(function () {
            $('.pull').slideToggle();
        });
    });

    $("#slider").responsiveSlides({
        auto: true,
        speed: 500,
        namespace: "callbacks",
        pager: true,
    });

    $('#horizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true   // 100% fit in a container
    });

    $('.popup-with-zoom-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: false,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in'
    });

    $(window).load(function () {
        setTimeout(hideURLbar, 0);
    })



    $(window).bind('scroll', function () {
        var navHeight = $("#jumb_box1").height();
        ($(window).scrollTop() > navHeight) ? $('nav').addClass('navbar-fixed-top') : $('nav').removeClass('navbar-fixed-top');
    });


    $("#list-towns").click(function (e) {

        e.preventDefault();

        $("#current-town").text($(e.target).text());

        location.replace($(e.target).attr('href'));
    });

    // $("#current-town").text($("#current-town").data('location'));

    /***********************************Registration form submit*****************************************/

    $('#user_reg').click(function (e) {

        e.preventDefault();

        $('#myRegistration').modal('show');

    });



    //console.log(ajax_object.ajax_nonce);
    //console.log(ajax_object.ajax_url)

    var msg_error = 'An error has occured. Please try again later.';
    var msg_timeout = 'The server is not responding';


    $("#zag-reg-submit").click(function (e) { 

        // check if the input is valid
        $("#form-reg").validate({
            rules: {
                user_login: {
                    required: true,
                    maxWords: 1,
                },
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
                user_password1: {
                    required: true,
                    maxWords: 1,
                },
                user_password2: {
                    required: true,
                    maxWords: 1,
                    equalTo: '#user_password1',
                },
            },
            messages: {
                user_login: {
                    required: 'Пожалуйста, введите Ваш логин',
                    maxWords: 'Логин должен состоять из одного непрерывного слова',
                },
                user_first_name: {
                    required: 'Пожалуйста, введите Ваше имя',
                    maxWords: 'Имя должно состоять из одного  слова',
                },
                user_last_name: {
                    maxWords: 'Имя должно состоять из одного  слова',
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
                user_password1: {
                    required: 'Пожалуйста, введите Ваш пароль',
                    maxWords: 'Пароль должен состоять из одного слова без пробелов'

                },
                user_password2: {
                    required: 'Пожалуйста, подтвердите Ваш пароль',
                    maxWords: 'Пароль должен состоять из одного слова без пробелов',
                    equalTo: 'Ошибка при подтверждении пароля',
                },
            }
        });

        $("#form-reg").trigger('submit')
    })

    $('#form-reg').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);


        if (!form.valid())
            return false;



        var formData = new FormData(this);

        //console.log($('#new-property-form input[type="file"]'))

        $('#form-reg input[type="file"]').each(function (index) {
            var file_data = this.files; // for multiple files


            formData.append("file", file_data);

        });


        formData.append('my_nonce', ajax_object.ajax_nonce);
        formData.append('action', 'zag_registration');





        $.ajax({
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: ajax_object.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {
                if (status === "timeout") {
                    alert(msg_timeout);
                } else {
                    alert(msg_error);
                }
            },
            success: function (response) {
                if (response.data.profile_link) {

                    location.reload();
                }

                if (response.data.errors) {

                    $('#myRegLabel').html('');

                    for (var form_error in response.data.errors) {
                        $('#myRegLabel').append("<p style='color: red;'>" + response.data.errors[form_error] + "</p>");

                    }
                    //console.log(response.data.error);
                }
            },
        });
    });

    /***************************************   Login ******************************************************/
    $('#user_login').click(function (e) {

        e.preventDefault();

        $('#myLogin').modal('show');

    });

    $("#zag-login").click(function () {

        $("#form-log").trigger('submit')
    })

    $('#form-log').on('submit', function (e) {

        e.preventDefault();


        var $form = $(this);

        // check if the input is valid
        if (!$form.valid())
            return false;

        var formLogin = new FormData(this);

        var cur_town = $("#current-town").text();

        formLogin.append('action', 'zag_login');
        formLogin.append('my_nonce', ajax_object.ajax_nonce);
        formLogin.append('cur_town', cur_town);

        $.ajax({
            data: formLogin,
            processData: false,
            contentType: false,
            dataType: 'json',
            url: ajax_object.ajax_url,
            method: 'POST',
            timeout: 5000
        })
                .done(function (data, textStatus, jqXHR) {
                     location.reload();
                })
                .fail(function ( jqXHR, textStatus, errorThrown) {
                    alert("error");
                })
               

    });

    /****************************************Logout ******************************************************/
     $("#user_logout").click(function () {



        $.ajax({
            data: {action: 'zag_logout'},
            dataType: 'json',
            url: ajax_object.ajax_url,
            method: 'POST',
            error: function (xhr, status, error) {

            },
            success: function (response) {
                if (response.data.link) {

                    location.replace(response.data.link);
                }


            },
            timeout: 5000
        });

    });


    //$('.carousel').carousel();


    /**************************************New property add rooms**********************************************
     
     var num_imgs = 0;
     var active;
     
     
     $("#room_add").on("change", "input[type='file']", function (e) {
     
     if (typeof (FileReader) != "undefined") {
     
     var input_index = $("#room_add input[type='file']").index(e.target);
     
     var dvPreview = $("#preview" + input_index);
     
     if (dvPreview.html()) {
     
     dvPreview.find('img').each(function (index) {
     
     var img_id = $(this).data('id');
     
     $('.carousel .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
     $('.carousel .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();
     
     num_imgs--;
     })
     
     $('.carousel .carousel-inner').find('div').each(function (index) {
     
     $(this).removeClass('active');
     
     if (0 == index) {
     $(this).addClass('active');
     }
     
     $(this).attr("data-id", index);
     });
     
     $('.carousel .carousel-indicators').find('li').each(function (index) {
     
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
     $('.carousel .carousel-inner').append('<div data-id="' + num_imgs + '" class="item ' + active + '"><img src="' + e.target.result + '" alt="..."> </div>')
     $('.carousel .carousel-indicators').append('<li data-id="' + num_imgs + '" data-target="#prop-slider" data-slide-to="' + num_imgs + '" class="' + active + '"></li>')
     
     num_imgs++;
     // console.log(car_items);
     
     
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
     
     $('.carousel').carousel();
     
     });
     
     
     
     $('#property_roomN').on('click', function (e) {
     
     var val = parseInt($(this).val());
     var leng = $("#room_add .room").length;
     
     if (leng < val) {
     var ind = val + 1;
     
     $("#room_add").append('<div id="id[' + ind + ']" class="form-group room">'
     + '<div  class="row">'
     + '<div class="col-xs-6">'
     + '<div class="input-group">'
     + '<select name="select[' + ind + ']" class="form-control">'
     + '<option value="dining">столовая</option>'
     + '<option value="sitting">гостинная</option>'
     + '<option value="bedroom">спальня</option>'
     + '</select>'
     + '</div>'
     + '</div>'
     + '<div class="col-xs-6">'
     + '<div class="input-group">'
     + '<input type="number" name="room_sq[' + ind + ']"  class="form-control" placeholder=" m2" />'
     + '<span class="input-group-addon">m2</span>'
     + '</div>'
     + '</div>'
     + '</div>'
     + '<div  class="row">'
     + '<div class="col-xs-4">'
     + '<div class="input-group">'
     + '<label class="btn btn-default btn-file">'
     + 'Загрузить фото <input type="file" style="display: none;" name="room_file[' + ind + ']"  class="form-control"  multiple>'
     + '</label>'
     + '</div>'
     + '</div>'
     + '<div class="col-xs-8">'
     + '<div id="preview' + ind + '"  class="input-group"></div>'
     + '</div>'
     + '</div>'
     + '</div>'
     );
     }
     
     if (leng > val) {
     
     var idd = leng + 1;
     
     var elem = $('#id\\[' + idd + '\\] img');
     
     $('#id\\[' + idd + '\\] img').each(function (index) {
     
     var img_id = $(this).data('id');
     
     $('.carousel .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
     $('.carousel .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();
     
     num_imgs--;
     })
     
     $('.carousel .carousel-inner').find('div').each(function (index) {
     
     $(this).removeClass('active');
     
     if (0 == index) {
     $(this).addClass('active');
     }
     
     $(this).attr("data-id", index);
     });
     
     $('.carousel .carousel-indicators').find('li').each(function (index) {
     
     $(this).removeClass('active');
     
     if (0 == index) {
     $(this).addClass('active');
     }
     
     $(this).attr("data-id", index);
     });
     
     
     
     var wew = $('#id\\[' + idd + '\\]')
     wew.remove();
     
     }
     
     
     
     });*/

    /*********************************New property form submit*******************************************
     $("#zag-new-prop").click(function (e) { 
     
     
     
     
     $("#new-property-form").trigger('submit')
     })
     
     $('#new-property-form').on('submit', function (e) {
     e.preventDefault();
     var formData = new FormData(this);
     
     //console.log($('#new-property-form input[type="file"]'))
     
     $('#new-property-form input[type="file"]').each(function (index) {
     var file_data = this.files; // for multiple files
     
     for (var i = 0; i < file_data.length; i++) {
     formData.append("file[" + index + "][" + i + "]", file_data[i]);
     }
     });
     
     var map_autocomplete = $("#autocomplete").val();
     
     var current_page = $("#current-town").data('slug');
     
     formData.append('action', 'zag_new_property');
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
     url: ajax_object.ajax_url,
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
     });*/


    /********************************************Add new property*************************************************/

    $('#zero_prop').on('click', function (e) {

        e.preventDefault();

        var zero_url = $(e.target).data('id') + '&town=' + $('#current-town').data('slug');

        $('#post-Iframe').attr('src', zero_url);

        $('#post-Iframe').on("load", function () {
            $('#prop-managment').modal('show');


        });


    });



    /*********************************Handling clicks on <a> in google map markers *******************************/
    $("#map").on("click", "a", function (e) {
        //console.log(e.target);


        e.preventDefault();


        var zero_url = $(e.target).attr('id') + '&town=' + $('#current-town').data('slug');

        $('#post-Iframe').attr('src', zero_url);
        $('#post-Iframe').on("load", function () {
            $('#prop-managment').modal('show');
        });

    });


});



function hideURLbar() {
    window.scrollTo(0, 10);
}
       