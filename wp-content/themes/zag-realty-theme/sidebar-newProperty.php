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
        dynamic_sidebar('sell');
        break;
    case 'buy':
        dynamic_sidebar('buy');
        break;
    case 'project':
        dynamic_sidebar('project');
        break;
    case 'rent_long':
        dynamic_sidebar('rent_long');
        break;
    case 'rent_rever':
        dynamic_sidebar('rent_rever');
        break;
    case 'rent_short':
        dynamic_sidebar('rent_short');
        break;
    case 'hostel':
        dynamic_sidebar('hostel');
        break;
}
?>



