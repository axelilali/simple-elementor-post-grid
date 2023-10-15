<?php
// TODO:
//  column padding
//  pagination button and settings
//  post taxonomies
// thumbnail min height
// column bottom margin for responsive
// global variable for text domaine
// replace boostrap with css grid

require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/helpers/truncate.php';

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
  return ['basic'];
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
    'label' => esc_html__('Content', 'ilalipostfilter'),
    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
   ]
  );

  $this->add_control(
   'query',
   [
    'label' => esc_html__('Query', 'ilalipostfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'post_type',
   [
    'label'   => esc_html__('Source', 'ilalipostfilter'),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => '',
    'options' => $available_post_types,
   ]
  );

  $this->add_control(
   'posts_per_page',
   [
    'label'   => esc_html__('Posts per page', 'ilalipostfilter'),
    'type'    => \Elementor\Controls_Manager::NUMBER,
    'min'     => 1,
    'max'     => 12,
    'step'    => 1,
    'default' => 6,
   ]
  );

  $this->add_control(
   'posts_order',
   [
    'label'   => esc_html__('Post order', 'ilalipostfilter'),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 'desc',
    'options' => [
     'asc'  => 'ASC',
     'desc' => "DESC",
    ],
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
    'label' => esc_html__('Settings', 'ilalipostfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'columns',
   [
    'label'   => esc_html__('Grid columns', 'ilalipostfilter'),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 3,
    'options' => [
     12 => 1,
     6  => 2,
     3  => 4,
     4  => 3,
    ],
   ]
  );

  $this->add_control(
   'excerpt_length',
   [
    'label'   => esc_html__('Excerpt length', 'ilalipostfilter'),
    'type'    => \Elementor\Controls_Manager::NUMBER,
    'min'     => 5,
    'max'     => 200,
    'step'    => 5,
    'default' => 20,
   ]
  );

  $this->add_control(
   'hr_2',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'show_thumbnail',
   [
    'label'        => esc_html__('Show thumbnail', 'ilalipostfilter'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'ilalipostfilter'),
    'label_off'    => esc_html__('Hide', 'ilalipostfilter'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_title',
   [
    'label'        => esc_html__('Show title', 'ilalipostfilter'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'ilalipostfilter'),
    'label_off'    => esc_html__('Hide', 'ilalipostfilter'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_date',
   [
    'label'        => esc_html__('Show date', 'ilalipostfilter'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'ilalipostfilter'),
    'label_off'    => esc_html__('Hide', 'ilalipostfilter'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_excerpt',
   [
    'label'        => esc_html__('Show excerpt', 'ilalipostfilter'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'ilalipostfilter'),
    'label_off'    => esc_html__('Hide', 'ilalipostfilter'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->end_controls_section();

  // STYLES
  $this->start_controls_section(
   'style_section',
   [
    'label' => esc_html__('Style', 'ilalipostfilter'),
    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
   ]
  );

  $this->add_control(
   'thumbnail_styling',
   [
    'label' => esc_html__('Thumbnail', 'ilalipostfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'thumbnail_width',
   [
    'label'      => esc_html__('Width', 'textdomain'),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => ['px', '%', 'em', 'rem', 'custom'],
    'range'      => [
     'px' => [
      'min'  => 0,
      'max'  => 1000,
      'step' => 5,
     ],
     '%'  => [
      'min' => 0,
      'max' => 100,
     ],
    ],
    'default'    => [
     'unit' => '%',
     'size' => 50,
    ],
    'selectors'  => [
     '{{WRAPPER}} .post-thumbnail' => 'width: {{SIZE}}{{UNIT}};',
    ],
   ]
  );

  $this->add_control(
   'thumbnail_height',
   [
    'label'      => esc_html__('Height', 'textdomain'),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => ['px', '%', 'em', 'rem', 'custom'],
    'range'      => [
     'px' => [
      'min'  => 0,
      'max'  => 1000,
      'step' => 5,
     ],
     '%'  => [
      'min' => 0,
      'max' => 100,
     ],
    ],
    'default'    => [
     'unit' => '%',
     'size' => '',
    ],
    'selectors'  => [
     '{{WRAPPER}} .post-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
    ],
   ]
  );

  $this->add_control(
   'thumbnail_divider',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'title_styling',
   [
    'label' => esc_html__('Title', 'ilalipostfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'title_color',
   [
    'label'     => esc_html__('Text Color', 'ilalipostfilter'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .post-title' => 'color: {{VALUE}};',
    ],
   ]
  );

  $this->add_group_control(
   \Elementor\Group_Control_Typography::get_type(),
   [
    'name'     => 'title_typography',
    'selector' => '{{WRAPPER}} .post-title',
   ]
  );

  $this->add_responsive_control(
   'title_align',
   [
    'label'     => esc_html__('Alignment', 'ilalipostfilter'),
    'type'      => \Elementor\Controls_Manager::CHOOSE,
    'options'   => [
     'left'   => [
      'title' => esc_html__('Left', 'ilalipostfilter'),
      'icon'  => 'eicon-text-align-left',
     ],
     'center' => [
      'title' => esc_html__('Center', 'ilalipostfilter'),
      'icon'  => 'eicon-text-align-center',
     ],
     'right'  => [
      'title' => esc_html__('Right', 'ilalipostfilter'),
      'icon'  => 'eicon-text-align-right',
     ],
    ],
    'default'   => 'left',
    'toggle'    => true,
    'selectors' => [
     '{{WRAPPER}} .post-title' => 'text-align: {{VALUE}};',
    ],
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
   'order'          => $settings['posts_order'],
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
     'content'      => limit_text(get_the_excerpt(), $settings['excerpt_length']),
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
