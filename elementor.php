<?php

/**
 * 121 Digital Projects Plugin - Elementor Widget
 *
 * This file defines a custom Elementor widget for the 121 Digital Projects Plugin.
 * The widget displays a grid of projects with options for customizing the number of posts,
 * grid columns, and thumbnail visibility. Users can choose to display project links either
 * as clickable areas or styled buttons. Button customization options include text, color,
 * hover color, padding, and border radius.
 *
 * The widget integrates seamlessly with Elementor, providing a flexible and user-friendly
 * way to present projects in a visually appealing grid format.
 *
 * Author: 121 Digital Services Limited
 * URL: 121digital.co.uk
 *
 * @package OneTwoOne_Digital
 * @author James Gibbons <jgibbons@121digital.co.uk>
 * @author 121 Digital services Limited
 * 
 * @link https://121digital.co.uk
 * 
 * 
 * 
 * 
 * 
 */

  namespace OneTwoOne_Digital;

  use Elementor\Widget_Base;
  use Elementor\Controls_Manager;

  if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
  }

  /**
   * Elementor Projects Widget Class
   */
  class Elementor_Projects_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
      return 'projects_widget';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
      return __('Projects Grid', 'projects');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
      return 'eicon-posts-grid';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
      return ['general'];
    }

    /**
     * Register widget controls.
     *
     * This method adds the controls for the widget in the Elementor editor.
     */
    protected function _register_controls() {
      // Content Controls
      $this->start_controls_section(
        'content_section',
        [
          'label' => __('Content', 'projects'),
          'tab' => Controls_Manager::TAB_CONTENT,
        ]
      );

      // Number of posts to display
      $this->add_control(
        'posts_per_page',
        [
          'label' => __('Posts Per Page', 'projects'),
          'type' => Controls_Manager::NUMBER,
          'default' => 10,
        ]
      );

      // Number of columns in the grid
      $this->add_control(
        'grid_columns',
        [
          'label' => __('Columns', 'projects'),
          'type' => Controls_Manager::SELECT,
          'default' => '3',
          'options' => [
            '1' => __('1', 'projects'),
            '2' => __('2', 'projects'),
            '3' => __('3', 'projects'),
            '4' => __('4', 'projects'),
          ],
        ]
      );

      // Show or hide project thumbnail
      $this->add_control(
        'show_thumbnail',
        [
          'label' => __('Show Thumbnail', 'projects'),
          'type' => Controls_Manager::SWITCHER,
          'label_on' => __('Yes', 'projects'),
          'label_off' => __('No', 'projects'),
          'return_value' => 'yes',
          'default' => 'yes',
        ]
      );

      // Link type: clickable area or button
      $this->add_control(
        'link_type',
        [
          'label' => __('Link Type', 'projects'),
          'type' => Controls_Manager::SELECT,
          'default' => 'clickable_area',
          'options' => [
            'clickable_area' => __('Clickable Area', 'projects'),
            'button' => __('Button', 'projects'),
          ],
        ]
      );

      // Button text
      $this->add_control(
        'button_text',
        [
          'label' => __('Button Text', 'projects'),
          'type' => Controls_Manager::TEXT,
          'default' => __('View Project', 'projects'),
          'condition' => [
            'link_type' => 'button',
          ],
        ]
      );

      $this->end_controls_section();

      // Style Controls
      $this->start_controls_section(
        'style_section',
        [
          'label' => __('Style', 'projects'),
          'tab' => Controls_Manager::TAB_STYLE,
        ]
      );

      // Grid gap
      $this->add_control(
        'grid_gap',
        [
          'label' => __('Grid Gap', 'projects'),
          'type' => Controls_Manager::NUMBER,
          'default' => 20,
          'min' => 0,
          'max' => 100,
          'step' => 1,
        ]
      );

      // Title color
      $this->add_control(
        'title_color',
        [
          'label' => __('Title Color', 'projects'),
          'type' => Controls_Manager::COLOR,
          'default' => '#333',
        ]
      );

      // Excerpt color
      $this->add_control(
        'excerpt_color',
        [
          'label' => __('Excerpt Color', 'projects'),
          'type' => Controls_Manager::COLOR,
          'default' => '#666',
        ]
      );

      // Title typography
      $this->add_control(
        'title_typography',
        [
          'label' => __('Title Typography', 'projects'),
          'type' => Controls_Manager::TYPOGRAPHY,
          'selectors' => [
            '{{WRAPPER}} .project-item h3' => 'font-size: {{SIZE}}{{UNIT}}; font-weight: {{FONT_WEIGHT}};',
          ],
        ]
      );

      // Excerpt typography
      $this->add_control(
        'excerpt_typography',
        [
          'label' => __('Excerpt Typography', 'projects'),
          'type' => Controls_Manager::TYPOGRAPHY,
          'selectors' => [
            '{{WRAPPER}} .project-item .project-excerpt' => 'font-size: {{SIZE}}{{UNIT}}; font-weight: {{FONT_WEIGHT}};',
          ],
        ]
      );

      // Button Style Controls
      $this->start_controls_section(
        'button_style_section',
        [
          'label' => __('Button Style', 'projects'),
          'tab' => Controls_Manager::TAB_STYLE,
          'condition' => [
            'link_type' => 'button',
          ],
        ]
      );

      // Button color
      $this->add_control(
        'button_color',
        [
          'label' => __('Button Color', 'projects'),
          'type' => Controls_Manager::COLOR,
          'default' => '#0073e6',
          'selectors' => [
            '{{WRAPPER}} .project-item .project-button' => 'background-color: {{VALUE}}; color: #fff;',
          ],
        ]
      );

      // Button hover color
      $this->add_control(
        'button_hover_color',
        [
          'label' => __('Button Hover Color', 'projects'),
          'type' => Controls_Manager::COLOR,
          'default' => '#005bb5',
          'selectors' => [
            '{{WRAPPER}} .project-item .project-button:hover' => 'background-color: {{VALUE}};',
          ],
        ]
      );

      // Button padding
      $this->add_control(
        'button_padding',
        [
          'label' => __('Button Padding', 'projects'),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => ['px', '%'],
          'selectors' => [
            '{{WRAPPER}} .project-item .project-button' => 'padding: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
          ],
        ]
      );

      // Button border radius
      $this->add_control(
        'button_border_radius',
        [
          'label' => __('Button Border Radius', 'projects'),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => ['px', '%'],
          'selectors' => [
            '{{WRAPPER}} .project-item .project-button' => 'border-radius: {{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
          ],
        ]
      );

      $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * @return void
     */
    protected function render() {
      $settings = $this->get_settings_for_display();
      $posts_per_page = $settings['posts_per_page'];
      $columns = $settings['grid_columns'];
      $grid_gap = $settings['grid_gap'];
      $title_color = $settings['title_color'];
      $excerpt_color = $settings['excerpt_color'];
      $show_thumbnail = $settings['show_thumbnail'] === 'yes';
      $link_type = $settings['link_type'];
      $button_text = $settings['button_text'];

      $query_args = array(
        'post_type' => 'project',
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'order' => 'DESC',
      );

      $query = new \WP_Query($query_args);

      if ($query->have_posts()) {
        // Output custom styles
        echo '<style>
          .projects-grid {
            grid-template-columns: repeat(' . esc_attr($columns) . ', 1fr);
            gap: ' . esc_attr($grid_gap) . 'px;
          }
          .project-item h3 {
            color: ' . esc_attr($title_color) . ';
          }
          .project-item .project-excerpt {
            color: ' . esc_attr($excerpt_color) . ';
          }
          .project-item .project-button {
            background-color: ' . esc_attr($settings['button_color']) . ';
            color: #fff;
            padding: ' . esc_attr($settings['button_padding']['top']) . ' ' . esc_attr($settings['button_padding']['right']) . ' ' . esc_attr($settings['button_padding']['bottom']) . ' ' . esc_attr($settings['button_padding']['left']) . ';
            border-radius: ' . esc_attr($settings['button_border_radius']['top']) . ' ' . esc_attr($settings['button_border_radius']['right']) . ' ' . esc_attr($settings['button_border_radius']['bottom']) . ' ' . esc_attr($settings['button_border_radius']['left']) . ';
          }
          .project-item .project-button:hover {
            background-color: ' . esc_attr($settings['button_hover_color']) . ';
          }
        </style>';

        echo '<div class="projects-grid">';
        
        while ($query->have_posts()) {
          $query->the_post();

          echo '<div class="project-item">';
          
          if ($show_thumbnail && has_post_thumbnail()) {
            echo '<a href="' . esc_url(get_post_meta(get_the_ID(), '_project_url', true)) . '">';
            the_post_thumbnail('medium');
            echo '</a>';
          }
          
          echo '<h3>' . get_the_title() . '</h3>';
          echo '<div class="project-excerpt">' . get_the_excerpt() . '</div>';

          if ($link_type === 'button') {
            echo '<a href="' . esc_url(get_post_meta(get_the_ID(), '_project_url', true)) . '" class="project-button">' . esc_html($button_text) . '</a>';
          } else {
            echo '<a href="' . get_permalink() . '"></a>'; // Ensure the whole project is clickable if not a button
          }
          
          echo '</div>';
        }
        
        echo '</div>';

        wp_reset_postdata();
      } else {
        echo '<p>' . __('No projects found.', 'projects') . '</p>';
      }
    }
  }

  /**
   * Register Elementor Projects Widget
   *
   * Registers the custom Elementor widget if Elementor is active.
   */
  function register_elementor_projects_widget() {
    // Check if Elementor is active
    if (defined('ELEMENTOR_VERSION')) {
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Projects_Widget());
    }
  }
  add_action('elementor/widgets/widgets_registered', 'OneTwoOne_Digital\register_elementor_projects_widget');
  ?>
