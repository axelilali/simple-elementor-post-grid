<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/helpers/truncate.php';

add_action('wp_ajax_nopriv_posts_pagination', 'posts_pagination');
add_action('wp_ajax_posts_pagination', 'posts_pagination');

function posts_pagination()
{
 global $twig;

 // Define the expected keys in $_POST
 $expected_keys = array(
  'page', 'postType', 'postOrder', 'postsPerPage',
  'excerptLength', 'columns', 'thumbnail', 'date', 'title', 'excerpt',
 );

 // Extract and filter only the expected keys from $_POST
 $sanitized_data = array_intersect_key(array_map('sanitize_text_field', $_POST), array_flip($expected_keys));

 // Validate and set default values if needed
 $sanitized_data['page']          = max(1, absint($sanitized_data['page'] ?? 1));
 $sanitized_data['postsPerPage']  = max(1, absint($sanitized_data['postsPerPage'] ?? 10));
 $sanitized_data['excerptLength'] = max(1, absint($sanitized_data['excerptLength'] ?? 100));
 $sanitized_data['columns']       = in_array($sanitized_data['columns'] ?? '4', array('1', '2', '3', '4'), true) ? $sanitized_data['columns'] : '4';
 $sanitized_data['thumbnail']     = filter_var($sanitized_data['thumbnail'] ?? false, FILTER_VALIDATE_BOOLEAN);
 $sanitized_data['date']          = filter_var($sanitized_data['date'] ?? false, FILTER_VALIDATE_BOOLEAN);
 $sanitized_data['title']         = filter_var($sanitized_data['title'] ?? false, FILTER_VALIDATE_BOOLEAN);
 $sanitized_data['excerpt']       = filter_var($sanitized_data['excerpt'] ?? false, FILTER_VALIDATE_BOOLEAN);

 // WP Query
 $context['posts']          = [];
 $context['columns']        = esc_attr($sanitized_data['columns']);
 $context['show_thumbnail'] = esc_attr($sanitized_data['thumbnail']);
 $context['show_title']     = esc_attr($sanitized_data['title']);
 $context['show_date']      = esc_attr($sanitized_data['date']);
 $context['show_excerpt']   = esc_attr($sanitized_data['excerpt']);

 $query = new WP_Query([
  'post_type'      => esc_attr($sanitized_data['postType']),
  'posts_per_page' => esc_attr($sanitized_data['postsPerPage']),
  'order'          => esc_attr($sanitized_data['postOrder']),
  'paged'          => esc_attr($sanitized_data['page']),
  'status'         => 'publish',
 ]);

 if ($query->have_posts()) {
  while ($query->have_posts()): $query->the_post();
   $context['posts'][] = [
    'title'        => get_the_title(),
    'link'         => esc_url(get_the_permalink()),
    'thumbnail'    => esc_url(get_the_post_thumbnail_url()),
    'category'     => esc_html(wp_get_post_terms(get_the_ID(), 'category')[0]->name),
    'categorySlug' => esc_html(wp_get_post_terms(get_the_ID(), 'category')[0]->slug),
    'content'      => esc_html(limit_text(get_the_excerpt(), $sanitized_data['excerptLength'])),
    'date'         => esc_html(get_the_date('j F Y')),
   ];
  endwhile;
 }

 wp_send_json([
  'data' => $twig->render('grid-item.twig', $context),
 ], 200);
}
