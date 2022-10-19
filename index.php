<?php

namespace GMContactForm;

/**
 * Plugin Name:       GM Contact Form
 * Update URI:        goodmotion-contact-form
 * Description:       This plugin allows you to display a Block for contact form subscription.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Faramaz Patrick <infos@goodmotion.fr>
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gm-contact-form
 *
 * @package           goodmotion
 */

require_once(dirname(__FILE__) . '/includes/form.php');
require_once(dirname(__FILE__) . '/includes/custom-post.php');
require_once(dirname(__FILE__) . '/includes/token.php');
require_once(dirname(__FILE__) . '/includes/options.php');


$PLUGIN_NAME = 'gm-contact-form';
$VERSION = '0.0.1';

// options page
new includes\options\SettingsPage();

/**
 * Load the plugin text domain for translation.
 *
 */ function load_textdomain()
{
  load_plugin_textdomain(
    'gm-contact-form',
    false,
    basename(dirname(__FILE__)) . '/languages'
  );
}

/**
 * load translations
 */
function set_script_translations()
{
  wp_set_script_translations('gm-contact-form', 'gm-contact-form', plugin_dir_path(__FILE__) . 'languages');
}

add_action('init', __NAMESPACE__ . '\load_textdomain');
add_action('init', __NAMESPACE__ . '\set_script_translations');



/**
 * render form
 */
function render_callback($attributes, $content)
{
  $token = \GMContactForm\includes\token\getToken();
  ob_start();
  require plugin_dir_path(__FILE__) . 'build/template.php';
  return ob_get_clean();
}



/**
 * add api endpoint
 */
add_action(
  'rest_api_init',
  function () {
    register_rest_route('gm_contact_form', '/action', array(
      'methods' => 'POST',
      'permission_callback' => '__return_true',
      'callback' => 'GMContactForm\includes\form\form_callback'
    ));
  }
);



/**
 * add api endpoint
 */
add_action(
  'rest_api_init',
  function () {
    register_rest_route('gm_contact_form', '/getToken', array(
      'methods' => 'GET',
      'permission_callback' => '__return_true',
      'callback' => 'GMContactForm\includes\form\get_token'
    ));
  }
);

/**
 * add script if block is in content
 */
add_action('wp_enqueue_scripts', function () use ($PLUGIN_NAME, $VERSION) {
  $id = get_the_ID();
  if (has_block('goodmotion/block-gm-contact-form', $id)) {
    // add script only if shortcode is used
    $path = plugins_url() . '/' . $PLUGIN_NAME;
    wp_enqueue_script($PLUGIN_NAME, $path . '/assets/scripts.js', array(), $VERSION, true);
  }
});

/**
 * block registration
 */
function block_init()
{
  register_block_type_from_metadata(__DIR__, [
    "render_callback" => __NAMESPACE__ . '\render_callback',
  ]);
}
add_action('init', __NAMESPACE__ . '\block_init');
