<?php
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/helpers/truncate.php';

add_action('wp_ajax_nopriv_posts_pagination', 'posts_pagination');
add_action('wp_ajax_posts_pagination', 'posts_pagination');

function posts_pagination()
{
 global $twig;

 // Destructure the $_POST array
 [
  'page'          => $paged,
  'postType'      => $postType,
  'postOrder'     => $postOrder,
  'postsPerPage'  => $postsPerPage,
  'excerptLength' => $excerptLength,
 ] = $_POST;

 // WP Query
 $context['posts'] = [];
 $query            = new WP_Query([
  'post_type'      => $postType,
  'posts_per_page' => $postsPerPage,
  'order'          => $postOrder,
  'paged'          => $paged,
  'status'         => 'publish',
 ]);

 if ($query->have_posts()) {
  while ($query->have_posts()): $query->the_post();
   $context['posts'][] = [
    'title'        => get_the_title(),
    'link'         => get_the_permalink(),
    'thumbnail'    => get_the_post_thumbnail_url(),
    'category'     => wp_get_post_terms(get_the_ID(), 'category')[0]->name,
    'categorySlug' => wp_get_post_terms(get_the_ID(), 'category')[0]->slug,
    'content'      => limit_text(get_the_excerpt(), $excerptLength),
    'date'         => get_the_date('j F Y'),
   ];
  endwhile;
 }

 wp_send_json([
  'data' => $twig->render('post-builder.twig', $context),
 ], 200);
}
