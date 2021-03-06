<?php
/*
  Plugin Name: Zag Loginout Widget
 */

// Block direct requests
if (!defined('ABSPATH'))
    die('-1');

/**
 * Adds My_Widget widget.
 */
class Zag_Edit_Sell_Property_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'Zag_Edit_Sell_Property_Widget', // Base ID
                __('Zag_Edit_Sell_Property_Widget', 'text_domain'), // Name
                array('description' => __('Zag_Edit_Sell_Property_Widget!', 'text_domain'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        $current_post = sanitize_post($GLOBALS['wp_the_query']->get_queried_object());

        $address_data = get_post_meta($current_post->ID, "address_data_ru", true);
        $prop_type = get_post_meta($current_post->ID, "property_type", true);

        $user_data = get_post_meta($current_post->ID, "user_info", true);

        $main_data = get_post_meta($current_post->ID, 'main_data', true);

        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $current_post->ID,
        ));

        $photo_files = array();
        $room = array();
        $roomSQ = array();

        foreach ($attachments as $key => $attach) {

            $photo_files[] = wp_get_attachment_url($attach->ID);
            $room[] = get_post_meta($attach->ID, 'room', true);
            $roomSQ[] = get_post_meta($attach->ID, 'roomSQ', true);
        }
        ?>

        <div class="container-fluid">

            <form id="edit-sell-form">

                <input type="hidden" name="latitude" id="latitude"  value="<?= $address_data['latitude'] ?>"/>	
                <input type="hidden" name="longitude" id="longitude" value="<?= $address_data['longitude'] ?>"/>	
                <input type="hidden" name="post_id" id="post_id" value="<?= $current_post->ID ?>"/>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align: center;">Редактировать - Продать</div>
                        </div>
                    </div>
                </div> <!-- Kind of prop -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Титульное сообщение</div>
                            <div class="panel-body">
                                <div class="input-group" style="width: 100%;">

                                    <input 
                                        type="text"
                                        name="shot_title"
                                        id="shot_title" 
                                        class="form-control" 
                                        value="<?= $main_data['shot_title'] ?>" 

                                        />	

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--Title panel -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Общие параметры</div>
                            <div class="panel-body">
                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-xs-6">
                                            <label>цена в $</label><br>
                                            <div class="input-group">
                                                <input type="number"
                                                       name="cost_US" 
                                                       id="cost_US" 
                                                       class="form-control"
                                                       min="1"
                                                       placeholder="цена" 
                                                       value="<?= $main_data['cost_US'] ?>000" 
                                                       />	
                                            </div> 
                                            <label id="priceDolError" style="color:red;" ></label>
                                        </div> 

                                        <div class="col-xs-6">
                                            <label>цена в грн</label><br>
                                            <div class="input-group">
                                                <input type="number" 
                                                       name="cost_GRN" 
                                                       id="cost_GRN" 
                                                       class="form-control" 
                                                       placeholder="цена" 
                                                       value="<?= $main_data['cost_GRN'] ?>000"
                                                       />	
                                            </div> 
                                        </div> 
                                    </div> 

                                    <div class="row">

                                        <div class="col-xs-6">
                                            <label>количество комнат</label><br>
                                            <div class="input-group">
                                                <input type="number" 
                                                       name="rooms" 
                                                       id="rooms" 
                                                       class="form-control"
                                                       placeholder="к-во комнат" min="1" max="10"  
                                                       value="<?= $main_data['rooms'] ?>"

                                                       />	
                                            </div>
                                            <label id="roomNError" style="color:red;" ></label>
                                        </div> 

                                        <div class="col-xs-6">
                                            <label>этажность</label><br/>

                                            <div class="input-group">

                                                <input type="text"
                                                       name="level" 
                                                       id="level" class="form-control" placeholder="этаж - этаж" 
                                                       value="<?= $main_data['level'] ?>"

                                                       />	
                                                <span class="input-group-addon">эт-эт</span>

                                            </div>

                                        </div> 
                                    </div> 

                                    <div class="row">

                                        <div class="col-xs-6">
                                            <label>общая площадь</label><br>
                                            <div class="input-group">

                                                <input type="number" 
                                                       name="totalSQ" 
                                                       id="totalSQ" class="form-control" placeholder="общая " 
                                                       value="<?= $main_data['totalSQ'] ?>"

                                                       />	
                                                <span class="input-group-addon">m2</span>
                                            </div> 
                                        </div> 
                                        <div class="col-xs-6">
                                            <label>жилая площадь</label><br>
                                            <div class="input-group">

                                                <input type="number" name="liveSQ" 
                                                       id="liveSQ" class="form-control" placeholder="жилая " 
                                                       value="<?= $main_data['liveSQ'] ?>"

                                                       />	
                                                <span class="input-group-addon">m2</span>
                                            </div> 
                                        </div>
                                        <div class="col-xs-6">
                                            <label>состояние</label><br>
                                            <div class="input-group">

                                                <select name="state" class="form-control">
                                                    <option value="от строителей"
                                                    <?php if ("от строителей" == $main_data['state']) echo ' selected'; ?>
                                                            >от строителей</option>
                                                    <option value="жилое"
                                                    <?php if ("жилое" == $main_data['state']) echo ' selected'; ?>
                                                            >жилое</option>
                                                    <option value="евроремонт"
                                                    <?php if ("евроремонт" == $main_data['state']) echo ' selected'; ?>
                                                            >евроремонт</option>
                                                    <option value="под ремонт"
                                                    <?php if ("под ремонт" == $main_data['state']) echo ' selected'; ?>
                                                            >под ремонт</option>
                                                </select>


                                            </div> 
                                        </div>

                                    </div> 


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="map"></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <?php foreach ($photo_files as $index => $photo): ?>
                                            <li data-target="#carousel-example-generic" data-slide-to="<?= $index ?>"
                                                class="<?php if (0 == $index) echo 'active'; ?>"></li>

                                        <?php endforeach; ?> 
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">

                                        <?php foreach ($photo_files as $index => $photo): ?>
                                            <div class="item <?php if (0 == $index) echo 'active'; ?>">
                                                <img src="<?= $photo ?>" alt="..." style="height: 300px;">
                                                <div class="carousel-caption" style="color: blue;">
                                                    <h3><?= $room[$index] ?></h3><h3><?= $roomSQ[$index] ?> м2</h3>
                                                </div>
                                            </div>

                                        <?php endforeach; ?> 

                                    </div>

                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- map -->

                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align: center;">Адрес</div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-xs-4">
                                        <label >номер дома</label>
                                        <div class="input-group">

                                            <input type="text" 
                                                   name="street_number" 
                                                   id="street_number" 
                                                   class="form-control" 
                                                   value="<?= $address_data['street_number'] ?>" 
                                                   disabled
                                                   />
                                        </div>
                                    </div> 

                                    <div class="col-xs-8">
                                        <label >улица</label>
                                        <div class="input-group">

                                            <input type="text" 
                                                   name="route" 
                                                   id="route" 
                                                   class="form-control" 
                                                   value="<?= $address_data['route'] ?>" 
                                                   disabled
                                                   />
                                        </div>

                                    </div> 
                                </div> 
                                <div class="row">

                                    <div class="col-xs-4">
                                        <label>город</label>
                                        <div class="input-group">

                                            <input type="text" 
                                                   name="locality" 
                                                   id="locality" 
                                                   class="form-control" 
                                                   value="<?= $address_data['locality'] ?>" 
                                                   disabled
                                                   />
                                        </div>
                                    </div> 

                                    <div class="col-xs-8">
                                        <label >район</label>
                                        <div class="input-group">

                                            <input type="text" 
                                                   name="sublocality_level_1" 
                                                   id="sublocality_level_1" 
                                                   class="form-control" 
                                                   value="<?= $address_data['sublocality_level_1'] ?>" 
                                                   disabled
                                                   />
                                        </div>

                                    </div> 
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Контактное лицо</div>
                            <div class="panel-body">
                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-xs-5">
                                            <label >Имя (обязательно)</label>
                                            <div class="input-group">

                                                <input type="text" 
                                                       name="user_first_name" 
                                                       id="user_first_name" 
                                                       class="form-control" 
                                                       value="<?= $user_data['user_first_name'] ?>" />
                                            </div>
                                        </div> 

                                        <div class="col-xs-7">
                                            <label >Фамилия </label>
                                            <div class="input-group">

                                                <input type="text" 
                                                       name="user_last_name" 
                                                       id="user_last_name" 
                                                       class="form-control" 
                                                       value="<?= $user_data['user_last_name'] ?>" />
                                            </div>

                                        </div> 
                                    </div> 

                                    <div class="row">

                                        <div class="col-xs-5">
                                            <label >Телефон</label>
                                            <div class="input-group">

                                                <input type="number" 
                                                       name="user_tel" 
                                                       id="user_tel" 
                                                       class="form-control" 
                                                       value="<?= $user_data['user_tel'] ?>" />
                                            </div>
                                        </div> 

                                        <div class="col-xs-7">
                                            <label >Email</label>
                                            <div class="input-group">

                                                <input type="email" 
                                                       name="user_email" 
                                                       id="user_email" 
                                                       class="form-control" 
                                                       value="<?= $user_data['user_email'] ?>" />	
                                            </div>

                                        </div> 
                                    </div> 

                                    <div class="row">

                                        <div class="col-xs-5">
                                            <label >Скайп</label>
                                            <div class="input-group">

                                                <input type="text" 
                                                       name="skype" 
                                                       id="skype" 
                                                       class="form-control" 
                                                       value="<?= $user_data['skype'] ?>" />
                                            </div>
                                        </div> 

                                        <div class="col-xs-7">
                                            <label >Вайбер</label>
                                            <div class="input-group">

                                                <input type="text" 
                                                       name="viber" 
                                                       id="viber" 
                                                       class="form-control" 
                                                       value="<?= $user_data['viber'] ?>" />	
                                            </div>

                                        </div> 
                                    </div> 

                                    <div class="row">

                                        <div class="col-xs-12">
                                            <label >cтатус</label>
                                            <div class="input-group">
                                                <select name="user_agency" class="form-control">
                                                    <?php if (get_user_meta($current_user->ID, "user_agency")[0]): ?>
                                                        <option value="agency"><?= get_user_meta($current_user->ID, "user_agency")[0] ?></option>
                                                    <?php else: ?>
                                                        <option value="хозяин">хозяин</option>
                                                        <option value="риэлтор">риэлтор</option>

                                                    <?php endif; ?>
                                                </select>


                                            </div>
                                        </div> 

                                    </div> 


                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- final address -->


                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align: center;">Краткое описание:</div>

                            <div class="panel-body">
                                <textarea 
                                    class="form-control" 
                                    rows="5" 
                                    name="comment" 
                                    placeholder=""><?= $main_data['comment'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div> <!--message -->

                <div id="row_error"  class="row" style="display: none;">
                    <div class="col-sm-12">
                        <div class="panel panel-default">

                            <div class="panel-heading" style="text-align: center;">Ошибки заполнения</div>

                            <div id="body_error" class="panel-body">

                            </div>
                        </div>
                    </div>
                </div> <!-- errors -->


                <?php
                wp_nonce_field('ajax-zag-registration-nonce', 'zag-registration');
                ?>
                <br>
                <button id="zag-edit-sell-prop" type="button" class="btn btn-primary">Сохранить редактирование</button>
                <button id="zag-unpublish-sell-prop" type="button" class="btn btn-warning">В архив</button>
                <button id="zag-delete-sell-prop" type="button" class="btn btn-danger">Удалить</button>

            </form>

        </div>


        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'text_domain');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}
