<?php
/**
 * Plugin Name: Projects
 * Plugin URI: https://121digital.co.uk
 * Description: A plugin to create a custom post type for projects with custom categories and project URL.
 * Version: 1.2
 * Author: 121 Digital Services Limited
 * Author URI: https://121digital.co.uk
 * License: GPL2
 */


 /** ======================================================================== */

 /**
 * 121 Digital Projects Plugin
 *
 * This file defines the main functionality for the 121 Digital Projects Plugin.
 * The plugin introduces a custom post type called "Projects" and a custom taxonomy
 * called "Project Categories", which are isolated from the default WordPress post types
 * and taxonomies. It includes an admin UI for managing projects and categories, as well
 * as a custom Elementor widget for displaying projects in a grid layout.
 *
 * The custom post type and taxonomy are fully integrated into the WordPress admin area,
 * providing a specialized interface for adding, editing, and organizing projects. The
 * Elementor widget offers a flexible and user-friendly way to showcase projects on the
 * front end, with various customization options including grid layout, thumbnail visibility,
 * and link styles.
 *
 * Author: 121 Digital Services Limited
 * URL: 121digital.co.uk
 *
 * @package OneTwoOne_Digital
 * @author James Gibbons <jgibbons@121digital.co.uk>
 * @author 121 Digital Services Limited
 * 
 * @link https://121digital.co.uk
 */

namespace OneTwoOne_Digital;

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

if (!class_exists('Projects_Plugin')) {

  class Projects_Plugin {

    public function __construct() {
      add_action('init', array($this, 'create_projects_post_type'));
      add_action('init', array($this, 'create_projects_taxonomy'), 0);
      add_action('add_meta_boxes', array($this, 'add_project_meta_box'));
      add_action('save_post', array($this, 'save_project_meta_box_data'));
    }

    /**
     * Create the custom post type for Projects
     */
    public function create_projects_post_type() {
      $labels = array(
        'name' => _x('Projects', 'Post type general name', 'projects'),
        'singular_name' => _x('Project', 'Post type singular name', 'projects'),
        'menu_name' => _x('Projects', 'Admin Menu text', 'projects'),
        'name_admin_bar' => _x('Project', 'Add New on Toolbar', 'projects'),
        'add_new' => __('Add New', 'projects'),
        'add_new_item' => __('Add New Project', 'projects'),
        'new_item' => __('New Project', 'projects'),
        'edit_item' => __('Edit Project', 'projects'),
        'view_item' => __('View Project', 'projects'),
        'all_items' => __('All Projects', 'projects'),
        'search_items' => __('Search Projects', 'projects'),
        'parent_item_colon' => __('Parent Projects:', 'projects'),
        'not_found' => __('No projects found.', 'projects'),
        'not_found_in_trash' => __('No projects found in Trash.', 'projects'),
        'featured_image' => _x('Project Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'projects'),
        'set_featured_image' => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'projects'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'projects'),
        'use_featured_image' => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'projects'),
        'archives' => _x('Project archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'projects'),
        'insert_into_item' => _x('Insert into project', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'projects'),
        'uploaded_to_this_item' => _x('Uploaded to this project', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'projects'),
        'filter_items_list' => _x('Filter projects list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'projects'),
        'items_list_navigation' => _x('Projects list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'projects'),
        'items_list' => _x('Projects list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'projects'),
      );

      $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'project'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest' => true,
      );

      register_post_type('project', $args);
    }

    /**
     * Create the custom taxonomy for Project Categories
     */
    public function create_projects_taxonomy() {
      $labels = array(
        'name' => _x('Project Categories', 'taxonomy general name', 'projects'),
        'singular_name' => _x('Project Category', 'taxonomy singular name', 'projects'),
        'search_items' => __('Search Project Categories', 'projects'),
        'all_items' => __('All Project Categories', 'projects'),
        'parent_item' => __('Parent Project Category', 'projects'),
        'parent_item_colon' => __('Parent Project Category:', 'projects'),
        'edit_item' => __('Edit Project Category', 'projects'),
        'update_item' => __('Update Project Category', 'projects'),
        'add_new_item' => __('Add New Project Category', 'projects'),
        'new_item_name' => __('New Project Category Name', 'projects'),
        'menu_name' => __('Project Categories', 'projects'),
      );

      $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'project-category'),
        'show_in_rest' => true,
      );

      register_taxonomy('project_category', array('project'), $args);
    }

    /**
     * Add custom meta box for Project URL
     */
    public function add_project_meta_box() {
      add_meta_box(
        'project_url_meta_box',
        __('Project URL', 'projects'),
        array($this, 'render_project_meta_box'),
        'project',
        'side',
        'default'
      );
    }

    /**
     * Render the Project URL meta box
     */
    public function render_project_meta_box($post) {
      wp_nonce_field('save_project_meta_box_data', 'project_meta_box_nonce');

      $value = get_post_meta($post->ID, '_project_url', true);

      echo '<label for="project_url">';
      _e('Project URL', 'projects');
      echo '</label> ';
      echo '<input type="text" id="project_url" name="project_url" value="' . esc_attr($value) . '" size="25" />';
    }

    /**
     * Save the Project URL meta box data
     */
    public function save_project_meta_box_data($post_id) {
      if (!isset($_POST['project_meta_box_nonce'])) {
        return;
      }

      if (!wp_verify_nonce($_POST['project_meta_box_nonce'], 'save_project_meta_box_data')) {
        return;
      }

      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
      }

      if (isset($_POST['post_type']) && 'page' === $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
          return;
        }
      } else {
        if (!current_user_can('edit_post', $post_id)) {
          return;
        }
      }

      if (!isset($_POST['project_url'])) {
        return;
      }

      $project_url = sanitize_text_field($_POST['project_url']);
      update_post_meta($post_id, '_project_url', $project_url);
    }
  }

  new Projects_Plugin();
}
?>
