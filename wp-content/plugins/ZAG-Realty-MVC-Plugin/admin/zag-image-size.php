<?php

 function zag_prop_img_sizes($sizes, $metadata) {
        if (DOING_AJAX && $_REQUEST['action'] == "zag_new_property") {

            unset($sizes['thumbnail']);
            unset($sizes['medium']);
            unset($sizes['large']);
            unset($sizes['medium-large']);

            
        }
        
        return $sizes;
    }

