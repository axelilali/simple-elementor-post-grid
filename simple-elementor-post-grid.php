<?php
/**
 * Plugin Name:     Simple Elementor Post Grid
 * Plugin URI:      https://github.com/axelilali/simple-elementor-post-grid
 * Description:     The plugin allow users to display any post types in a grid like fashion and give users the capability to filter those posts.
 * License:         GPLv2 or later
 * License URI:     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Author:          Axel Ilali
 * Author URI:      https://axel-ilali.com
 * Text Domain:     simple-elementor-post-grid
 * Version:         1.0.0
 * Requires at least: 5.8
 * Tested up to: 6.2
 * Requires PHP: 7.3
 *
 * @package         SimpleElementorPostGrid
 */
if (!defined('ABSPATH')) {
 exit;
}

require_once __DIR__ . '/helpers/posts-pagination.php';

//  register scripts and styles
function elementor_post_grid_widgets_dependencies()
{
 wp_register_script('post-grid', plugins_url('assets/js/main.js', __FILE__), [], null, true);
 wp_register_style('bootstrap-grid', plugins_url('libs/bootstrap/bootstrap-grid.min.css', __FILE__), null, 'all');
}
add_action('wp_enqueue_scripts', 'elementor_post_grid_widgets_dependencies');

function enqueue_style()
{
 wp_enqueue_script('post-grid');
 wp_enqueue_style('bootstrap-grid');
}
add_action('wp_enqueue_scripts', 'enqueue_style');

// load widget
function register_widgets($widgets_manager)
{
 require_once __DIR__ . '/widgets/post-grid.php';
 $widgets_manager->register(new \SimpleElementorPostGrid());
}

add_action('elementor/widgets/register', 'register_widgets');
