<?php
// ini_set('display_errors', 1);
/**
 * Plugin Name:     Elementor Post Grid
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Display any post type and filter your post grid easily !
 * Author:          Axel Ilali
 * Author URI:      https://axel-ilali.com
 * Text Domain:     ilalipostfilter
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Ilali_Postfilter
 */

//  register scripts and styles
function elementor_post_grid_widgets_dependencies()
{

 wp_register_style('bootstrap-grid', plugins_url('libs/bootstrap/bootstrap-grid.min.css', __FILE__), null, 'all');
}
add_action('wp_enqueue_scripts', 'elementor_post_grid_widgets_dependencies');

function enqueue_style()
{
 wp_enqueue_style('bootstrap-grid');

}
add_action('wp_enqueue_scripts', 'enqueue_style');

function register_widgets($widgets_manager)
{
 require_once __DIR__ . '/widgets/post-grid.php';

 $widgets_manager->register(new \Ilali_PostGrid());
}

add_action('elementor/widgets/register', 'register_widgets');
