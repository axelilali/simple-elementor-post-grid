<?php
require_once dirname(__DIR__) . '/bootstrap.php';

class Ilali_PostGrid extends \Elementor\Widget_Base

{

 public function get_name()
 {
  return 'ilali-postgrid';
 }

 public function get_title()
 {
  return 'Post Grid';
 }

 public function get_icon()
 {
  return 'eicon-gallery-grid';
 }

 public function get_categories()
 {
  return ['eanet-addons'];
 }

 public function get_keywords()
 {
  return ['post', 'filter'];
 }

 protected function register_controls()
 {

// Get all post types
  $post_types           = get_post_types(array(), 'objects');
  $available_post_types = [];
// Filter out post types without the 'post' capability
  $filtered_post_types = array_filter($post_types, function ($post_type) {
   return post_type_supports($post_type->name, 'editor'); // Check if the post type supports the 'editor' capability
  });

// Output the list of post types
  foreach ($filtered_post_types as $post_type) {
   $available_post_types[$post_type->name] = $post_type->label;
  }

  // CONTENT
  $this->start_controls_section(
   'content_section',
   [
    'label' => esc_html__('Content', 'ilali-postfilter'),
    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
   ]
  );

  $this->add_control(
   'query',
   [
    'label' => esc_html__('Query', 'ilali-postfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'post_type',
   [
    'label'   => esc_html__('Post Type', 'ilali-postfilter'),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 'solid',
    'options' => $available_post_types,
   ]
  );

  $this->add_control(
   'posts_per_page',
   [
    'label'   => esc_html__('Posts per page', 'textdomain'),
    'type'    => \Elementor\Controls_Manager::NUMBER,
    'min'     => 1,
    'max'     => 12,
    'step'    => 1,
    'default' => 6,
   ]
  );

  $this->add_control(
   'hr',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'settings',
   [
    'label' => esc_html__('Settings', 'ilali-postfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'columns',
   [
    'label'   => esc_html__('Grid columns', 'ilali-postfilter'),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 'solid',
    'options' => [
     12 => 1,
     6  => 2,
     3  => 4,
     4  => 3,
    ],
   ]
  );

  $this->end_controls_section();

  // STYLES
  $this->start_controls_section(
   'style_section',
   [
    'label' => esc_html__('Style', 'ilali-postfilter'),
    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
   ]
  );

  $this->add_control(
   'title_styling',
   [
    'label' => esc_html__('Title', 'ilali-postfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'title_color',
   [
    'label'     => esc_html__('Text Color', 'ilali-postfilter'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .post-title' => 'color: {{VALUE}};',
    ],
   ]
  );

  $this->add_group_control(
   \Elementor\Group_Control_Typography::get_type(),
   [
    'name'     => 'content_typography',
    'selector' => '{{WRAPPER}} .post-title',
   ]
  );

  $this->add_control(
   'hr',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->end_controls_section();

 }

 protected function render()
 {
  global $twig;
  global $wpdb;

  $settings             = $this->get_settings_for_display();
  $context['widget_id'] = str_replace(".", "", $this->get_unique_selector());
  $context['settings']  = $settings;

  // WP Query
  $context['posts'] = [];
  $query            = new WP_Query([
   'post_type'      => $settings['post_type'],
   'posts_per_page' => $settings['posts_per_page'],
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
     'content'      => get_the_excerpt(),
     'date'         => get_the_date('j F Y'),
    ];
   endwhile;
  }

  echo $twig->render('post-grid.twig', $context);
 }

 protected function content_template()
 {
 }

}
