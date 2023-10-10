<?php
/**
 * Plugin Name:     Elementor Post Grid
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Display any post type and filter your post grid easily !
 * Author:          Axel Ilali
 * Author URI:      https://axel-ilali.com
 * Text Domain:     ilali-postfilter
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Ilali_Postfilter
 */

function register_widgets($widgets_manager)
{
 require_once __DIR__ . '/widgets/post-grid.php';

 $widgets_manager->register(new \Ilali_PostGrid());
}

add_action('elementor/widgets/register', 'register_widgets');
