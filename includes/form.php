<?php

namespace GMContactForm\includes\form;

require_once(dirname(__FILE__) . '/token.php');

/**
 * REST route for form submission.
 */
function form_callback(\WP_REST_Request $request)
{
  $tokenReal = \GMContactForm\includes\token\getToken();
  // get token from form
  $token =  $request->get_param('token');
  // if robot, beer is not null
  $trap =  $request->get_param('beer');
  if ($token !== $tokenReal || $trap !== null) {
    return new \WP_Error('invalid_token', 'Invalid token', array('status' => 403));
  }

  $email = sanitize_email($request->get_param('email'));
  $name = sanitize_text_field($request->get_param('name'));
  $message = sanitize_text_field($request->get_param('message'));

  // save in db
  $post_id = wp_insert_post([
    'post_type' => 'gm-contacts',
    'post_title' => $email,
    'post_content' => $message,
    'post_status' => 'publish'
  ]);

  if (!$post_id) {
    return [
      'error' => true,
      'message' => 'ERROR'
    ];
  }
  // save name
  add_post_meta($post_id, 'name', $name);

  // email
  $from = get_option('gm_smtp_from');
  $fromName = get_option('gm_smtp_from_name');
  if ($from) {
    // create header
    $headers[] = 'From: ' . $fromName . ' <' . $from . '>';
    // copy
    $headers[] = 'Cc: ' . $email;
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    // subject of email
    $subject = __('Contact message from ', 'gm-contact-form') . get_option('blogname');

    // message html
    $message = "<ul><li><strong>" . __('Date', 'gm-contact-form') . ":</strong><br /> "  . date('D j M à H:i') . "<br /></li><li><strong>" . __('Email', 'gm-contact-form') . ":</strong><br /> <a href=\"mailto:" . $email . "\">" . $email . "</a><br /></li>
  <li><strong>" . __('Name', 'gm-contact-form') . ":</strong><br /> "  . $name . "<br /></li><li><strong>" . __('Message', 'gm-contact-form') . ":</strong><br /> "  . $message . "<br /></li></ul>";

    // send email
    $b = wp_mail(
      $from,
      $subject,
      $message,
      $headers
    );

    if (!$b) {
      return [
        'error' => true,
        'message' => 'ERROR'
      ];
    }
  }
  // ok :)
  return [
    'error' => false,
    'message' => 'EMAIL_SEND'
  ];
}


function get_token(\WP_REST_Request $request)
{
  $tokenReal = \GMContactForm\includes\token\getToken();
  return ['token' => $tokenReal];
}
