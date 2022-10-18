<?php

namespace GMContactForm\includes\customPost;


function get_excerpt($length = 50)
{
  $excerpt = get_the_content();
  $excerpt = preg_replace(" ([.*?])", '', $excerpt);
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $length);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
  $excerpt = strlen($excerpt) === 0 ? $excerpt : $excerpt . '...';
  return $excerpt;
}

/**
 * custom list
 */
function custom_css()
{
  if (isset($_GET['post_type']) && 'gm-contacts' == $_GET['post_type']) {
    echo '<style>.subsubsub .publish, .hide-if-no-js {display: none;}</style>';
  }
}

add_action('admin_head', __NAMESPACE__ . '\custom_css');


/**
 * metabox for edit page
 */
function metaBox()
{
  global $post;
  echo "<div class=\"gm-contact-details\"><ul><li><strong>" . __('Date', 'gm-contact-form') . ":</strong> "  . get_the_date('D j M à H:i') . "</li><li><strong>" . __('Email', 'gm-contact-form') . ":</strong> <a href=\"mailto:" . $post->post_title . "\">" . $post->post_title . "</a></li>
  <li><strong>" . __('Name', 'gm-contact-form') . ":</strong> "  . get_post_meta($post->ID, 'name', true) . "</li><li><strong>" . __('Message', 'gm-contact-form') . ":</strong> "  . $post->post_content . "</li></ul></div>
    <style>#publishing-action, #misc-publishing-actions, .postbox-header, #postbox-container-1 {
      display: none;
    }
    .gm-contact-details li {
      margin: 1rem 0;
    }
    .gm-contact-details strong {
      text-decoration: underline;
      display: block;
      margin-bottom: .5rem;
    }

  ";
}

/**
 * label
 */
function get_labels(): array
{
  return array(
    'name' => __('Contacts', 'gm-contact-form'),
    'singular_name' => __('Contact', 'gm-contact-form'),
    'add_new' => __('Add', 'gm-contact-form'),
    'add_new_item' => __('Add new Contact', 'gm-contact-form'),
    'edit_item' => __('Contact', 'gm-contact-form'),
    'new_item' => __('New Contact', 'gm-contact-form'),
    'view_item' => __('See the Contact', 'gm-contact-form'),
    'search_items' => __('Search Contact', 'gm-contact-form'),
    'not_found' => __('No Contact found', 'gm-contact-form'),
    'not_found_in_trash' => __('No Contact in trash', 'gm-contact-form'),
    'parent_item_colon' => __('Parent Contact:', 'gm-contact-form'),
    'contact_name' => __('Contacts', 'gm-contact-form'),
  );
}


/**
 * create custom post type
 */
function custom_post_type()
{
  register_post_type(
    'gm-contacts',
    array(
      'labels'      => namespace\get_labels(),
      'show_in_rest' => false,
      'supports' => array(''),
      'menu_position' => 8,
      'menu_icon' => 'dashicons-email',
      'rewrite'     => array('slug' => 'contacts', 'with_front' => false),
      'public' => false,
      'show_ui' => true,
      'capability_type' => 'post',
      'capabilities' => array(
        'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
      ),
      'map_meta_cap' => true,
      'register_meta_box_cb' => function () {
        add_meta_box('gm-contact-box', 'gm-contact-box', __NAMESPACE__ . '\metaBox');
      }
    )
  );
}
add_action('init', __NAMESPACE__ . '\custom_post_type');


/**
 * remove action list row
 */
function remove_row_actions($actions)
{
  if (get_post_type() === 'gm-contacts')
    unset($actions['edit']);
  unset($actions['view']);
  unset($actions['trash']);
  unset($actions['inline hide-if-no-js']);
  return $actions;
}

add_filter('post_row_actions', __NAMESPACE__ . '\remove_row_actions', 10, 1);


/**
 * edit the column name and order
 */
function set_custom_edit_columns($columns)
{
  unset($columns['date']);
  return array_merge($columns, array(
    'title' => __('Email', 'gm-contact-form'),
    'name' => __('Name', 'gm-contact-form'),
    'message' => __('Message', 'gm-contact-form'),
    'date_send' => __('Date', 'gm-contact-form'),
  ));
}

add_filter('manage_gm-contacts_posts_columns',  __NAMESPACE__ . '\set_custom_edit_columns');




// Add the data to the custom columns for post type:
function custom_column($column, $post_id)
{
  switch ($column) {
    case 'name':
      echo get_post_meta($post_id, 'name', true);
      break;
    case 'date_send':
      echo get_the_date('D j M à H:i');
      break;
    case 'message':
      echo namespace\get_excerpt(50);
  }
}

add_action('manage_gm-contacts_posts_custom_column',  __NAMESPACE__ . '\custom_column', 10, 2);
