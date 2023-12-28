<?php

if (!defined('ABSPATH')) {
 exit;
}
// Exit if accessed directly

require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/helpers/truncate.php';

class SimpleElementorPostGrid extends \Elementor\Widget_Base

{

 public function get_name()
 {
  return 'simple-elementor-post-grid';
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
  return ['post', 'grid'];
 }

 protected function register_controls()
 {

// Get all post types
  $post_types           = get_post_types(array(), 'objects');
  $available_post_types = [];

// Filter out post types without the 'post' capability
  $filtered_post_types = array_filter($post_types, function ($post_type) {
   // Check if the post type supports the 'editor' capability
   return post_type_supports($post_type->name, 'editor');
  });

// Output the list of post types
  foreach ($filtered_post_types as $post_type) {
   $available_post_types[$post_type->name] = $post_type->label;
  }

  // CONTENT
  $this->start_controls_section(
   'content_section',
   [
    'label' => esc_html__('Content', 'simple-elementor-post-grid'),
    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
   ]
  );

  $this->add_control(
   'query',
   [
    'label' => esc_html__('Query', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'post_type',
   [
    'label'   => esc_html__('Source', 'simple-elementor-post-grid'),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => '',
    'options' => $available_post_types,
   ]
  );

  $this->add_control(
   'posts_per_page',
   [
    'label'   => esc_html__('Posts per page', 'simple-elementor-post-grid'),
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
    'label'   => esc_html__('Post order', 'simple-elementor-post-grid'),
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
    'label' => esc_html__('Settings', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'columns',
   [
    'label'   => esc_html__('Grid columns', 'simple-elementor-post-grid'),
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
    'label'   => esc_html__('Excerpt length', 'simple-elementor-post-grid'),
    'type'    => \Elementor\Controls_Manager::NUMBER,
    'min'     => 5,
    'max'     => 200,
    'step'    => 5,
    'default' => 20,
   ]
  );

  $this->add_responsive_control(
   'column_bottom_spacing',
   [
    'label'      => esc_html__('Bottom spacing', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => ['px', '%', 'em', 'rem'],
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
     'unit' => 'px',
     'size' => 50,
    ],
    'selectors'  => [
     '{{WRAPPER}} .column' => 'margin-bottom: {{SIZE}}{{UNIT}};',
    ],
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
    'label'        => esc_html__('Show thumbnail', 'simple-elementor-post-grid'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'simple-elementor-post-grid'),
    'label_off'    => esc_html__('Hide', 'simple-elementor-post-grid'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_title',
   [
    'label'        => esc_html__('Show title', 'simple-elementor-post-grid'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'simple-elementor-post-grid'),
    'label_off'    => esc_html__('Hide', 'simple-elementor-post-grid'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_date',
   [
    'label'        => esc_html__('Show date', 'simple-elementor-post-grid'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'simple-elementor-post-grid'),
    'label_off'    => esc_html__('Hide', 'simple-elementor-post-grid'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_excerpt',
   [
    'label'        => esc_html__('Show excerpt', 'simple-elementor-post-grid'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'simple-elementor-post-grid'),
    'label_off'    => esc_html__('Hide', 'simple-elementor-post-grid'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'show_pagination',
   [
    'label'        => esc_html__('Enable pagination', 'simple-elementor-post-grid'),
    'type'         => \Elementor\Controls_Manager::SWITCHER,
    'label_on'     => esc_html__('Show', 'simple-elementor-post-grid'),
    'label_off'    => esc_html__('Hide', 'simple-elementor-post-grid'),
    'return_value' => 'yes',
    'default'      => 'yes',
   ]
  );

  $this->add_control(
   'hr_3',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'button_text',
   [
    'label'   => esc_html__('Button text', 'simple-elementor-post-grid'),
    'type'    => \Elementor\Controls_Manager::TEXT,
    'default' => 'Load More',
   ]
  );

  $this->end_controls_section();

  // STYLES
  $this->start_controls_section(
   'style_section',
   [
    'label' => esc_html__('Style', 'simple-elementor-post-grid'),
    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
   ]
  );

  $this->add_control(
   'thumbnail_styling',
   [
    'label' => esc_html__('Thumbnail', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_responsive_control(
   'thumbnail_width',
   [
    'label'      => esc_html__('Width', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => ['px', '%', 'em', 'rem'],
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
     '{{WRAPPER}} .post-thumbnail' => 'width: {{SIZE}}{{UNIT}};',
    ],
   ]
  );

  $this->add_responsive_control(
   'thumbnail_height',
   [
    'label'      => esc_html__('Height', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => ['px', '%', 'em', 'rem'],
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
   'thumbnail_fit',
   [
    'label'     => esc_html__('Image fit', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::SELECT,
    'default'   => 'cover',
    'options'   => [
     'none'       => 'None',
     'contain'    => 'Contain',
     'fit'        => 'Fit',
     'cover'      => 'Cover',
     'scale-down' => 'Scale-down',
    ],
    'selectors' => [
     '{{WRAPPER}} .post-thumbnail' => 'object-fit: {{VALUE}};',
    ],
   ]
  );

  $this->add_control(
   'thumbnail-position',
   [
    'label'     => esc_html__('Image position', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::SELECT,
    'default'   => 'none',
    'options'   => [
     'top'    => 'Top',
     'bottom' => 'Bottom',
     'left'   => 'Left',
     'right'  => 'Right',
     'center' => 'Center',
    ],
    'selectors' => [
     '{{WRAPPER}} .post-thumbnail' => 'object-position: {{VALUE}};',
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
    'label' => esc_html__('Title', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'title_color',
   [
    'label'     => esc_html__('Text Color', 'simple-elementor-post-grid'),
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
    'label'     => esc_html__('Alignment', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::CHOOSE,
    'options'   => [
     'left'   => [
      'title' => esc_html__('Left', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-left',
     ],
     'center' => [
      'title' => esc_html__('Center', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-center',
     ],
     'right'  => [
      'title' => esc_html__('Right', 'simple-elementor-post-grid'),
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

  $this->add_responsive_control(
   'title_margin',
   [
    'label'      => esc_html__('Margin', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', '%', 'em', 'rem'],
    'selectors'  => [
     '{{WRAPPER}} .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
   ]
  );

  $this->add_control(
   'title_divider',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'date_styling',
   [
    'label' => esc_html__('Date', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'date_color',
   [
    'label'     => esc_html__('Date color', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .post-date' => 'color: {{VALUE}};',
    ],
   ]
  );

  $this->add_group_control(
   \Elementor\Group_Control_Typography::get_type(),
   [
    'name'     => 'date_typography',
    'selector' => '{{WRAPPER}} .post-date',
   ]
  );

  $this->add_responsive_control(
   'date_align',
   [
    'label'     => esc_html__('Alignment', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::CHOOSE,
    'options'   => [
     'left'   => [
      'title' => esc_html__('Left', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-left',
     ],
     'center' => [
      'title' => esc_html__('Center', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-center',
     ],
     'right'  => [
      'title' => esc_html__('Right', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-right',
     ],
    ],
    'default'   => 'left',
    'toggle'    => true,
    'selectors' => [
     '{{WRAPPER}} .post-date' => 'text-align: {{VALUE}};',
    ],
   ]
  );

  $this->add_responsive_control(
   'date_margin',
   [
    'label'      => esc_html__('Margin', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', '%', 'em', 'rem'],
    'selectors'  => [
     '{{WRAPPER}} .post-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
   ]
  );

  $this->add_control(
   'date_divider',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'excerpt_styling',
   [
    'label' => esc_html__('Excerpt', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'excerpt_color',
   [
    'label'     => esc_html__('Excerpt color', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .post-content' => 'color: {{VALUE}};',
    ],
   ]
  );

  $this->add_group_control(
   \Elementor\Group_Control_Typography::get_type(),
   [
    'name'     => 'date_typography',
    'selector' => '{{WRAPPER}} .post-content',
   ]
  );

  $this->add_responsive_control(
   'excerpt_align',
   [
    'label'     => esc_html__('Alignment', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::CHOOSE,
    'options'   => [
     'left'   => [
      'title' => esc_html__('Left', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-left',
     ],
     'center' => [
      'title' => esc_html__('Center', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-center',
     ],
     'right'  => [
      'title' => esc_html__('Right', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-right',
     ],
    ],
    'default'   => 'left',
    'toggle'    => true,
    'selectors' => [
     '{{WRAPPER}} .post-content' => 'text-align: {{VALUE}};',
    ],
   ]
  );

  $this->add_responsive_control(
   'excerpt_margin',
   [
    'label'      => esc_html__('Margin', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', '%', 'em', 'rem'],
    'selectors'  => [
     '{{WRAPPER}} .post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
   ]
  );

  $this->add_control(
   'excerpt_divider',
   [
    'type' => \Elementor\Controls_Manager::DIVIDER,
   ]
  );

  $this->add_control(
   'pagination_styling',
   [
    'label' => esc_html__('Button', 'simple-elementor-post-grid'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_group_control(
   \Elementor\Group_Control_Typography::get_type(),
   [
    'name'     => 'btn_typography',
    'selector' => '{{WRAPPER}} .pagination-btn',
   ]
  );

  $this->start_controls_tabs(
   'style_tabs'
  );

  $this->start_controls_tab(
   'style_normal_tab',
   [
    'label' => esc_html__('Normal', 'simple-elementor-post-grid'),
   ]
  );

  $this->add_control(
   'pagination_btn_color',
   [
    'label'     => esc_html__('Color', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn' => 'color: {{VALUE}};',
    ],
   ]);

  $this->add_control(
   'pagination_btn_background',
   [
    'label'     => esc_html__('Background', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn' => 'background-color: {{VALUE}};',
    ],
   ]);

  $this->add_control(
   'pagination_btn_border',
   [
    'label'     => esc_html__('Border color', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn' => 'border-color: {{VALUE}};',
    ],
   ]);

  $this->end_controls_tab();

  $this->start_controls_tab(
   'style_hover_tab',
   [
    'label' => esc_html__('Hover', 'simple-elementor-post-grid'),
   ]);

  $this->add_control(
   'pagination_btn_color_hover',
   [
    'label'     => esc_html__('Color', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn:hover' => 'color: {{VALUE}};',
    ],
   ]);

  $this->add_control(
   'pagination_btn_background_hover',
   [
    'label'     => esc_html__('Background', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn:hover' => 'background-color: {{VALUE}};',
    ],
   ]
  );

  $this->add_control(
   'pagination_btn_border_hover',
   [
    'label'     => esc_html__('Border color', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn:hover' => 'border-color: {{VALUE}};',
    ],
   ]);

  $this->end_controls_tab();

  $this->end_controls_tabs();

  $this->add_responsive_control(
   'pagination_btn_padding',
   [
    'label'      => esc_html__('Padding', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', '%', 'em', 'rem'],
    'selectors'  => [
     '{{WRAPPER}} .pagination-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
   ]
  );

  $this->add_control(
   'pagination_btn_border_type',
   [
    'label'     => esc_html__('Border style', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::SELECT,
    'default'   => 'solid',
    'options'   => [
     'solid'  => 'Solid',
     'dotted' => "dotted",
     'double' => "Double",
     'dashed' => "Dashed",
     'groove' => "Groove",
    ],
    'selectors' => [
     '{{WRAPPER}} .pagination-btn' => 'border-style: {{VALUE}};',
    ],
   ]
  );

  $this->add_responsive_control(
   'pagination_btn_border_width',
   [
    'label'      => esc_html__('Border width', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', 'em', 'rem'],
    'selectors'  => [
     '{{WRAPPER}} .pagination-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
   ]
  );

  $this->add_responsive_control(
   'pagination_btn_border_radius',
   [
    'label'      => esc_html__('Border radius', 'simple-elementor-post-grid'),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => ['px', 'em', 'rem'],
    'selectors'  => [
     '{{WRAPPER}} .pagination-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
   ]
  );

  $this->add_responsive_control(
   'pagination_btn_position',
   [
    'label'     => esc_html__('Alignment', 'simple-elementor-post-grid'),
    'type'      => \Elementor\Controls_Manager::CHOOSE,
    'options'   => [
     'left'   => [
      'title' => esc_html__('Left', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-left',
     ],
     'center' => [
      'title' => esc_html__('Center', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-center',
     ],
     'right'  => [
      'title' => esc_html__('Right', 'simple-elementor-post-grid'),
      'icon'  => 'eicon-text-align-right',
     ],
    ],
    'default'   => 'left',
    'toggle'    => true,
    'selectors' => [
     '{{WRAPPER}} .pagination-btn-container' => 'text-align: {{VALUE}};',
    ],
   ]
  );

  $this->end_controls_section();

 }

 protected function render()
 {
  global $twig;

  $settings             = $this->get_settings_for_display();
  $context['site_url']  = site_url();
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
     'content'      => get_the_excerpt(),
     'date'         => get_the_date('j F Y'),
    ];
   endwhile;
  }

  $context['max_pages'] = $query->max_num_pages;

  // Escaping late
  $context['site_url']  = esc_url($context['site_url']);
  $context['widget_id'] = esc_attr($context['widget_id']);
  $context['settings']  = array_map('sanitize_text_field', $context['settings']);

  foreach ($context['posts'] as &$post) {
   $post['title']        = esc_html($post['title']);
   $post['link']         = esc_url($post['link']);
   $post['thumbnail']    = esc_url($post['thumbnail']);
   $post['category']     = esc_html($post['category']);
   $post['categorySlug'] = esc_html($post['categorySlug']);
   $post['content']      = esc_html(limit_text($post['content'], $settings['excerpt_length']));
   $post['date']         = esc_html($post['date']);
  }

  $context['max_pages'] = esc_attr($context['max_pages']);

  echo $twig->render('post-grid.twig', $context);
 }

 protected function content_template()
 {}
}
