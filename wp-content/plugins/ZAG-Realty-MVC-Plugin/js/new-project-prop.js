jQuery(function ($) {
    
    $("#shot_title").val(function (index, value) {
        return "Новострой  на "+ $("#route").val();
    })
    
     $("#route").on("change", function (e) {
        return "Новострой  на "+ $(this).val();
    });
    


    function addPanel(index, room) {

        var newProject = $("#project-draft").clone();
        newProject.attr('id', room + '-project-' + index);
        newProject.find('input[type="file"]').attr('name', room + '-room-file[' + index + ']');
        newProject.find('.pr-text').text('Проект N' + parseInt(index + 1));

        newProject.find('.preview').attr('id', room + 'RoomPreview-' + index);

        newProject.find('.btn-danger').attr('data-id', '' + index);

        newProject.find('#-priceUS-').attr('id', room + '-priceUS-' + index).attr('name', room + '-room-priceUS[' + index + ']');
        newProject.find('#-priceGRN-').attr('id', room + '-priceGRN-' + index).attr('name', room + '-room-priceGRN[' + index + ']');

        newProject.find('#-totalSQ-').attr('id', room + '-totalSQ-' + index).attr('name', room + '-room-totalSQ[' + index + ']');
        newProject.find('#-liveSQ-').attr('id', room + '-liveSQ-' + index).attr('name', room + '-room-liveSQ[' + index + ']');

        newProject.find('#comment').attr('id', room + '-comment-' + index).attr('name', room + '-room-comment[' + index + ']');

        newProject.find('#proj-left').attr('id', room + '-proj-left-' + index).attr('name', room + '-room-proj-left[' + index + ']');


        newProject.css('display', 'block');

        return  newProject;
    }


    var active;
    /*********************************************************One************************************************/
    var num_imgs = 0;

    $("#oneRoomButton").click(function (e) { 

        var room = 'one';
        var prLength = $("#oneRoom .zag-project").length;


        $("#oneRoom").append(function (index, html) {
            return addPanel(prLength, room);
        })


    });

    $("#oneRoom").on("click", "button.btn-danger", function (e) {


        var delet_index = $("#oneRoom button.btn-danger").index(e.target);

        $("#one-project-" + delet_index).remove();

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


        $("#oneRoom .zag-project").each(function (index) {

            var panel_elem = $(this);

            panel_elem.attr('id', 'one-project-' + index);
            panel_elem.find('input[type="file"]').attr('name', 'one-room-file[' + index + ']');
            panel_elem.find('.pr-text').text('Проект N' + parseInt(index + 1));

            panel_elem.find('.preview').attr('id', 'oneRoomPreview-' + index);


            panel_elem.find('.btn-danger ').attr('data-id', '' + index);
        });




    })

    $("#oneRoom").on("change", "input[type='file']", function (e) {

        if (typeof (FileReader) != "undefined") {



            if (num_imgs < 0)
                num_imgs = 0;

            var input_index = $("#oneRoom input[type='file']").index(e.target);

            var dvPreview = $("#oneRoomPreview-" + input_index);




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

    /*********************************************************two************************************************/
    var num_imgs_two = 0;

    $("#twoRoomButton").click(function (e) { 

        var room = 'two';
        var prLength = $("#twoRoom .zag-project").length;


        $("#twoRoom").append(function (index, html) {
            return addPanel(prLength, room);
        })


    });

    $("#twoRoom").on("click", "button.btn-danger", function (e) {


        var delet_index = $("#twoRoom button.btn-danger").index(e.target);

        $("#two-project-" + delet_index).remove();

        $('#two-room-slider .carousel-inner').find('div[data-id = "' + delet_index + '"]').remove();
        $('#two-room-slider .carousel-indicators').find('li[data-id = "' + delet_index + '"]').remove();

        $('#two-room-slider .carousel-inner').find('div').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        $('#two-room-slider .carousel-indicators').find('li').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        num_imgs_two--;


        $("#twoRoom .zag-project").each(function (index) {

            var panel_elem = $(this);

            panel_elem.attr('id', 'two-project-' + index);
            panel_elem.find('input[type="file"]').attr('name', 'two-room-file[' + index + ']');
            panel_elem.find('.pr-text').text('Проект N' + parseInt(index + 1));

            panel_elem.find('.preview').attr('id', 'twoRoomPreview-' + index);


            panel_elem.find('.btn-danger ').attr('data-id', '' + index);
        });




    })

    $("#twoRoom").on("change", "input[type='file']", function (e) {

        if (typeof (FileReader) != "undefined") {

            var input_index = $("#twoRoom input[type='file']").index(e.target);

            var dvPreview = $("#twoRoomPreview-" + input_index);




            if (dvPreview.html()) {

                dvPreview.find('img').each(function (index) {

                    var img_id = $(this).data('id');

                    $('#two-room-slider .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
                    $('#two-room-slider .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();

                    num_imgs_two--;
                })

                $('#two-room-slider .carousel-inner').find('div').each(function (index) {

                    $(this).removeClass('active');

                    if (0 == index) {
                        $(this).addClass('active');
                    }

                    $(this).attr("data-id", index);
                });

                $('#two-room-slider .carousel-indicators').find('li').each(function (index) {

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
                        img.attr("data-id", num_imgs_two);

                        dvPreview.append(img);
                        if (0 == num_imgs_two) {
                            active = 'active';
                        } else {
                            active = '';
                        }


                        $('#two-room-slider .carousel-inner').append('<div data-id="' + num_imgs_two + '" class="item ' + active + '"><img src="' + e.target.result + '" alt="..."> </div>')
                        $('#two-room-slider .carousel-indicators').append('<li data-id="' + num_imgs_two + '" data-target="#prop-slider" data-slide-to="' + num_imgs_two + '" class="' + active + '"></li>')

                        num_imgs_two++;
                        // console.log(car_items);

                        $('#two-room-slider').data('bs.carousel', '');
                        $('#two-room-slider').carousel();

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

    /*********************************************************three************************************************/
    var num_imgs_three = 0;

    $("#threeRoomButton").click(function (e) { 

        var room = 'three';
        var prLength = $("#threeRoom .zag-project").length;


        $("#threeRoom").append(function (index, html) {
            return addPanel(prLength, room);
        })


    });

    $("#threeRoom").on("click", "button.btn-danger", function (e) {


        var delet_index = $("#threeRoom button.btn-danger").index(e.target);

        $("#three-project-" + delet_index).remove();

        $('#three-room-slider .carousel-inner').find('div[data-id = "' + delet_index + '"]').remove();
        $('#three-room-slider .carousel-indicators').find('li[data-id = "' + delet_index + '"]').remove();

        $('#three-room-slider .carousel-inner').find('div').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        $('#three-room-slider .carousel-indicators').find('li').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        num_imgs_three--;


        $("#threeRoom .zag-project").each(function (index) {

            var panel_elem = $(this);

            panel_elem.attr('id', 'three-project-' + index);
            panel_elem.find('input[type="file"]').attr('name', 'three-room-file[' + index + ']');
            panel_elem.find('.pr-text').text('Проект N' + parseInt(index + 1));

            panel_elem.find('.preview').attr('id', 'threeRoomPreview-' + index);


            panel_elem.find('.btn-danger ').attr('data-id', '' + index);
        });




    })

    $("#threeRoom").on("change", "input[type='file']", function (e) {

        if (typeof (FileReader) != "undefined") {

            var input_index = $("#threeRoom input[type='file']").index(e.target);

            var dvPreview = $("#threeRoomPreview-" + input_index);




            if (dvPreview.html()) {

                dvPreview.find('img').each(function (index) {

                    var img_id = $(this).data('id');

                    $('#three-room-slider .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
                    $('#three-room-slider .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();

                    num_imgs_three--;
                })

                $('#three-room-slider .carousel-inner').find('div').each(function (index) {

                    $(this).removeClass('active');

                    if (0 == index) {
                        $(this).addClass('active');
                    }

                    $(this).attr("data-id", index);
                });

                $('#three-room-slider .carousel-indicators').find('li').each(function (index) {

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
                        img.attr("data-id", num_imgs_three);

                        dvPreview.append(img);
                        if (0 == num_imgs_three) {
                            active = 'active';
                        } else {
                            active = '';
                        }


                        $('#three-room-slider .carousel-inner').append('<div data-id="' + num_imgs_three + '" class="item ' + active + '"><img src="' + e.target.result + '" alt="..."> </div>')
                        $('#three-room-slider .carousel-indicators').append('<li data-id="' + num_imgs_three + '" data-target="#prop-slider" data-slide-to="' + num_imgs_three + '" class="' + active + '"></li>')

                        num_imgs_three++;
                        // console.log(car_items);

                        $('#three-room-slider').data('bs.carousel', '');
                        $('#three-room-slider').carousel();

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
    /*********************************************************fore************************************************/
    var num_imgs_fore = 0;

    $("#foreRoomButton").click(function (e) { 

        var room = 'fore';
        var prLength = $("#foreRoom .zag-project").length;


        $("#foreRoom").append(function (index, html) {
            return addPanel(prLength, room);
        })


    });

    $("#foreRoom").on("click", "button.btn-danger", function (e) {


        var delet_index = $("#foreRoom button.btn-danger").index(e.target);

        $("#fore-project-" + delet_index).remove();

        $('#fore-room-slider .carousel-inner').find('div[data-id = "' + delet_index + '"]').remove();
        $('#fore-room-slider .carousel-indicators').find('li[data-id = "' + delet_index + '"]').remove();

        $('#fore-room-slider .carousel-inner').find('div').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        $('#fore-room-slider .carousel-indicators').find('li').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        num_imgs_fore--;


        $("#foreRoom .zag-project").each(function (index) {

            var panel_elem = $(this);

            panel_elem.attr('id', 'fore-project-' + index);
            panel_elem.find('input[type="file"]').attr('name', 'fore-room-file[' + index + ']');
            panel_elem.find('.pr-text').text('Проект N' + parseInt(index + 1));

            panel_elem.find('.preview').attr('id', 'foreRoomPreview-' + index);


            panel_elem.find('.btn-danger ').attr('data-id', '' + index);
        });




    })

    $("#foreRoom").on("change", "input[type='file']", function (e) {

        if (typeof (FileReader) != "undefined") {

            var input_index = $("#foreRoom input[type='file']").index(e.target);

            var dvPreview = $("#foreRoomPreview-" + input_index);




            if (dvPreview.html()) {

                dvPreview.find('img').each(function (index) {

                    var img_id = $(this).data('id');

                    $('#fore-room-slider .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
                    $('#fore-room-slider .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();

                    num_imgs_fore--;
                })

                $('#fore-room-slider .carousel-inner').find('div').each(function (index) {

                    $(this).removeClass('active');

                    if (0 == index) {
                        $(this).addClass('active');
                    }

                    $(this).attr("data-id", index);
                });

                $('#fore-room-slider .carousel-indicators').find('li').each(function (index) {

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
                        img.attr("data-id", num_imgs_fore);

                        dvPreview.append(img);
                        if (0 == num_imgs_fore) {
                            active = 'active';
                        } else {
                            active = '';
                        }


                        $('#fore-room-slider .carousel-inner').append('<div data-id="' + num_imgs_fore + '" class="item ' + active + '"><img src="' + e.target.result + '" alt="..."> </div>')
                        $('#fore-room-slider .carousel-indicators').append('<li data-id="' + num_imgs_fore + '" data-target="#prop-slider" data-slide-to="' + num_imgs_fore + '" class="' + active + '"></li>')

                        num_imgs_fore++;
                        // console.log(car_items);

                        $('#fore-room-slider').data('bs.carousel', '');
                        $('#fore-room-slider').carousel();

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

    /*********************************************************pent************************************************/

    var num_imgs_pent = 0;

    $("#pentRoomButton").click(function (e) { 

        var room = 'pent';
        var prLength = $("#pentRoom .zag-project").length;


        $("#pentRoom").append(function (index, html) {
            return addPanel(prLength, room);
        })


    });

    $("#pentRoom").on("click", "button.btn-danger", function (e) {


        var delet_index = $("#pentRoom button.btn-danger").index(e.target);

        $("#pent-project-" + delet_index).remove();

        $('#pent-room-slider .carousel-inner').find('div[data-id = "' + delet_index + '"]').remove();
        $('#pent-room-slider .carousel-indicators').find('li[data-id = "' + delet_index + '"]').remove();

        $('#pent-room-slider .carousel-inner').find('div').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        $('#pent-room-slider .carousel-indicators').find('li').each(function (index) {

            $(this).removeClass('active');

            if (0 == index) {
                $(this).addClass('active');
            }

            $(this).attr("data-id", index);
        });

        num_imgs_pent--;


        $("#pentRoom .zag-project").each(function (index) {

            var panel_elem = $(this);

            panel_elem.attr('id', 'pent-project-' + index);
            panel_elem.find('input[type="file"]').attr('name', 'pent-room-file[' + index + ']');
            panel_elem.find('.pr-text').text('Проект N' + parseInt(index + 1));

            panel_elem.find('.preview').attr('id', 'pentRoomPreview-' + index);


            panel_elem.find('.btn-danger ').attr('data-id', '' + index);
        });




    })

    $("#pentRoom").on("change", "input[type='file']", function (e) {

        if (typeof (FileReader) != "undefined") {

            var input_index = $("#pentRoom input[type='file']").index(e.target);

            var dvPreview = $("#pentRoomPreview-" + input_index);




            if (dvPreview.html()) {

                dvPreview.find('img').each(function (index) {

                    var img_id = $(this).data('id');

                    $('#pent-room-slider .carousel-inner').find('div[data-id = "' + img_id + '"]').remove();
                    $('#pent-room-slider .carousel-indicators').find('li[data-id = "' + img_id + '"]').remove();

                    num_imgs_pent--;
                })

                $('#pent-room-slider .carousel-inner').find('div').each(function (index) {

                    $(this).removeClass('active');

                    if (0 == index) {
                        $(this).addClass('active');
                    }

                    $(this).attr("data-id", index);
                });

                $('#pent-room-slider .carousel-indicators').find('li').each(function (index) {

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
                        img.attr("data-id", num_imgs_pent);

                        dvPreview.append(img);
                        if (0 == num_imgs_pent) {
                            active = 'active';
                        } else {
                            active = '';
                        }


                        $('#pent-room-slider .carousel-inner').append('<div data-id="' + num_imgs_pent + '" class="item ' + active + '"><img src="' + e.target.result + '" alt="..."> </div>')
                        $('#pent-room-slider .carousel-indicators').append('<li data-id="' + num_imgs_pent + '" data-target="#prop-slider" data-slide-to="' + num_imgs_pent + '" class="' + active + '"></li>')

                        num_imgs_pent++;
                        // console.log(car_items);

                        $('#pent-room-slider').data('bs.carousel', '');
                        $('#pent-room-slider').carousel();

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
    $("#zag-new-project-prop").click(function (e) { 


        $("#new-project-form").trigger('submit');
    })

    $('#new-project-form').on('submit', function (e) {
        e.preventDefault();



        var formData = new FormData(this);

        $('#new-project-form input[type="file"]').each(function (index) {
            var file_data = this.files; // for multiple files


            formData.append("file", file_data);

        });

        //console.log($('#new-property-form input[type="file"]'))


        var map_autocomplete = $("#autocomplete").val();

        var current_page = $("#current-town").data('slug');

        formData.append('action', 'zag_new_project_prop_ajax_action');
        formData.append('coming_new_project_nonce', ajax_new_project.new_project_nonce);
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
            url: ajax_new_project.ajax_url,
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





