<?php

/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage zag
 * @since Twenty Sixteen 1.0
 */


$prop_type = sanitize_text_field($_GET['prop_type']);

switch ($prop_type) {
    case 'sell':
        dynamic_sidebar('see_sell');
        break;
    case 'buy':
        dynamic_sidebar('see_buy');
        break;
    case 'project':
        dynamic_sidebar('see_project');
        break;
    case 'rent_long':
        dynamic_sidebar('see_rent_long');
        break;
    case 'rent_rever':
        dynamic_sidebar('see_rent_rever');
        break;
    case 'rent_short':
        dynamic_sidebar('see_rent_short');
        break;
    case 'hostel':
        dynamic_sidebar('see_hostel');
        break;
}

?>

