<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
<!--        <link rel="profile" href="http://gmpg.org/xfn/11">-->
<!--        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">-->
        <!--[if lt IE 9]>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
        <![endif]-->
        <?php
        wp_head();
        global $current_town;
        global $post;
        global $props_array;

        $current_town = 'Украина';
        $slug = 'ukraine';



        $current_user = wp_get_current_user();



        if (is_page()) {
// Get the queried object and sanitize it
            $current_page = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());
// Get the page slug
            $slug = $current_page->post_name;

            switch ($slug) {
                case 'kiev':
                    $current_town = 'Киев';
                    $town_term = 'kiev';
                    break;
                case 'odessa':
                    $current_town = 'Одесса';
                    $town_term = 'odesa';
                    break;
                case 'lviv':
                    $current_town = 'Львов';
                    $town_term = 'lviv';
                    break;
                default :
                    $slug = 'ukraine';
                    $current_town = 'Украина';
            }
        }


        $my_page_query = new WP_Query(
                array(
            'post_type' => 'zag_property',
            'term' => $town_term,
            'posts_per_page' => '10',
            'post_status' => 'publish',
            'author' => $current_user->ID,
            'meta_key' => 'property_type',
            'meta_value' => '',
                )
        );

        $props_array = array();

        if ($my_page_query->have_posts()) {
            while ($my_page_query->have_posts()) {
                $my_page_query->the_post();
                $address = get_post_meta($post->ID, "address_data", true);
                $main_prop_features = get_post_meta($post->ID, "main_data", true);
                $user_info = get_post_meta($post->ID, "user_info", true);
                $post_type = get_post_meta($post->ID, "property_type", true);



                $props_array[] = array(
                    'lat' => $address['latitude'],
                    'lng' => $address['longitude'],
                    'price' => $main_prop_features['cost_US']."000",
                    'rooms' => $main_prop_features['rooms'],
                    'real_id' => get_post_permalink($post->ID),
                    'post_type' => $post_type,
                );
            }
        }
        wp_reset_postdata();

        function qqq() {
            global $props_array;
            wp_localize_script("ukrain-google-map", 'some_map_object', $props_array);
        }

        add_action('wp_print_footer_scripts', 'qqq', 1);
        ?>
    </head>

    <body <?php body_class(); ?> >

        <div class="jumbotron">

            <div class="container-fluid ">
                <!-- box1 -->
                <div id="jumb_box1" class="home">
                    <div class="text-vcenter">
                        <h1>Недвижимость в Украине</h1>

                        <div class="jquery-script-ads" align="center">
                            <script type="text/javascript">

                                google_ad_client = "ca-pub-2783044520727903";
                                /* jQuery_demo */
                                google_ad_slot = "2780937993";
                                google_ad_width = 728;
                                google_ad_height = 90;

                            </script>
                            <script type="text/javascript"
                                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- navbar -->
        <nav  id="nav-top" class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse row" id="bs-example-navbar-collapse-1">
                    <div class="col-md-4" style="font-size: 1.5em;">
                        <ul class="nav navbar-nav " >
                            <li><a href="#">Главная <span class="sr-only"></span></a></li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Выбери свой город<span class="caret"></span></a>
                                <ul id="list-towns" class="dropdown-menu">
                                    <li><a href=" <?php echo esc_url(home_url( '/index.php/kiev' ))?>">Киев</a></li>
                                    <li><a href="<?php echo esc_url(home_url( '/index.php/odessa' ))?>">Одесса</a></li>
                                    <li><a href="<?php echo esc_url(home_url( '/index.php/lviv' ))?>">Львов</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4" >

                        <ul class="nav navbar-nav" style="margin: 0 30%;" >
                            <li><a id="current-town"  data-slug="<?= $slug ?>" href="" style="font-size: 2.5em;"><?= $current_town; ?></a> </li>

                        </ul>

                    </div>
                    <div class="col-md-4">

                        <?php
                        get_sidebar('loginout');
                        ?>



                    </div>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- /navbar --> 
        <!-- /box1 --> 

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-1">

                </div>
                <div class="col-md-10">
                    <div id="map"></div>
                </div>
                <div class="col-md-1">

                </div>

            </div>
        </div>



        <!--header-bottom-->
        <div class="banner-bottom-top">
            <div class="container">
                <div class="bottom-header">
                    <div class="header-bottom">
                        <div class=" bottom-head">
                            <a href="">
                                <div class="buy-media">
                                    <i class="sell"> </i>
                                    <h6>Продать</h6>
                                </div>
                            </a>
                        </div>
                        <div class=" bottom-head">
                            <a href="">
                                <div class="buy-media">
                                    <i class="buy"> </i>
                                    <h6>Купить</h6>
                                </div>
                            </a>
                        </div>
                        <div class=" bottom-head">
                            <a href="">
                                <div class="buy-media">
                                    <i class="newproject"> </i>
                                    <h6>Новострои</h6>
                                </div>
                            </a>
                        </div>
                        <div class=" bottom-head">
                            <a href="">
                                <div class="buy-media">
                                    <i class="rentLong"> </i>
                                    <h6>Сдать долгосрочно</h6>
                                </div>
                            </a>
                        </div>
                         <div class=" bottom-head">
                            <a href="">
                                <div class="buy-media">
                                    <i class="rentShort"> </i>
                                    <h6>Сдать посуточно</h6>
                                </div>
                            </a>
                        </div>
                         <div class=" bottom-head">
                            <a href="dealers.html">
                                <div class="buy-media">
                                    <i class="rentRever"> </i>
                                    <h6>Сниму</h6>
                                </div>
                            </a>
                        </div>
                        <div class=" bottom-head">
                            <a href="buy.html">
                                <div class="buy-media">
                                    <i class="hostel"> </i>
                                    <h6>Хостелы</h6>
                                </div>
                            </a>
                        </div>
                        
                       
                        
                       
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
        </div>
        <!--//-->

        <!--//header-bottom-->


        <!--//header-->

        <!-- Modal  Login-->
        <div class="modal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myLoginLabel" >
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Login</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-log">
                            <div class="form-group">
                                <label for="user_login">Login</label>
                                <input type="text" name="user_login" id="user_login" class="form-control" placeholder="Login" />	

                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input type="password" name="user_password" class="form-control" id="user_password" placeholder="Password">
                            </div>


                            <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="zag-login-close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="zag-login" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal  Registration-->
        <div class="modal fade" id="myRegistration" tabindex="-1" role="dialog" aria-labelledby="myRegistrationLabel" >
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div id="myRegLabel"><h4 class="modal-title" >Registration</h4></div>
                    </div>
                    <div class="modal-body">
                        <form id="form-reg">
                            <div class="form-group">
                                <label for="user_login">Логин </label>
                                <input type="text" 
                                       name="user_login" 
                                       id="user_login_reg" 
                                       class="form-control" 
                                       placeholder="Введите Ваш пароль"  
                                       value="bob" 
                                       required/>	

                            </div>

                            <div class="form-group">
                                <label for="user_first_name">Имя</label>
                                <input type="text" 
                                       name="user_first_name" 
                                       id="user_first_name" 
                                       class="form-control" 
                                       placeholder="Введите Ваше имя"  
                                       value="bob" 
                                       required/>	
                            </div>

                            <div class="form-group">
                                <label for="user_last_name">Фамилия</label>
                                <input type="text" 
                                       name="user_last_name" 
                                       id="user_last_name" 
                                       class="form-control" 
                                       placeholder="Введите Вашу фамилию"  
                                       value="bob" />	
                            </div>

                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="text" 
                                       name="user_email" 
                                       id="user_email" 
                                       class="form-control" 
                                       placeholder="Введите Ваш  email"
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                                       value="bob@bob.bob" 
                                       required/>	
                            </div>

                            <div class="form-group">
                                <label for="user_tel">Телефон</label>
                                <input type="number" 
                                       name="user_tel" 
                                       id="user_tel" 
                                       class="form-control" 
                                       placeholder="Введите Ваш телефон" 
                                       pattern="\d+"
                                       value="067777777" 
                                       required/>	
                            </div>

                            <div class="form-group">
                                <label for="user_agency">Агенство</label>
                                <input type="text" 
                                       name="user_agency" 
                                       id="user_agency" 
                                       class="form-control" 
                                       placeholder="Введите Ваше агенство"  
                                       value="Kombo"/>	
                            </div>

                            <div class="form-group">
                                <label for="user_password1">Пароль</label>
                                <input type="password" 
                                       name="user_password1" 
                                       class="form-control" 
                                       id="user_password1" 
                                       placeholder="Введите Ваш пароль" 
                                       value="bob" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="user_password2">Подтвердить пароль</label>
                                <input type="password"  
                                       name="user_password2" 
                                       class="form-control" 
                                       id="user_password2" 
                                       placeholder="Подтвердите Ваш пароль"  
                                       value="bob" 
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="thumbnail">Фото</label>

                                <input type="file" name="thumbnail" id="thumbnail">

                            </div>

                            <?php
                            wp_nonce_field('ajax-zag-registration-nonce', 'zag-registration');

                            /*
                             * wp-includes/functions.php
                             * 'ajax-zag-registration-nonce' - action name
                             *  'zag-registration' - id of <input> tag
                             * 
                             */
                            ?>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="zag-reg-close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="zag-reg-submit" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade " id="prop-managment" tabindex="-1" role="dialog"  aria-labelledby="myPropLabel">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content" >

                    <div class="modal-body" style="height: 800px;">

                        <iframe id="post-Iframe" src="" class="embed-responsive-item" frameborder="0" style="width: 100%; height: 100%"></iframe>

                    </div>
                    <div class="modal-footer">
                        <button id="single-prop-close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>



