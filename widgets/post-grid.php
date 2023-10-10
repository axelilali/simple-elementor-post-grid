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

  $this->start_controls_section(
   'content_section',
   [
    'label' => esc_html__('Content', 'ilali-postfilter'),
    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
   ]
  );

  $this->end_controls_section();

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
    'label' => esc_html__('Title styling', 'ilali-postfilter'),
    'type'  => \Elementor\Controls_Manager::HEADING,
   ]
  );

  $this->add_control(
   'title_color',
   [
    'label'     => esc_html__('Text Color', 'ilali-postfilter'),
    'type'      => \Elementor\Controls_Manager::COLOR,
    'selectors' => [
     '{{WRAPPER}} .text' => 'color: {{VALUE}};',
    ],
   ]
  );

  $this->add_group_control(
   \Elementor\Group_Control_Typography::get_type(),
   [
    'name'     => 'content_typography',
    'selector' => '{{WRAPPER}} .text',
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

  $gallery  = [];
  $settings = $this->get_settings_for_display();

  $context['widget_id'] = str_replace(".", "", $this->get_unique_selector());
  $context['settings']  = $settings;

  echo $twig->render('post-grid.twig', $context);
 }

 protected function content_template()
 {
 }

}
