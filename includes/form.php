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
  $title = sanitize_text_field($request->get_param('title'));
  $firstname = sanitize_text_field($request->get_param('firstname'));
  $lastname = sanitize_text_field($request->get_param('lastname'));
  $society = sanitize_text_field($request->get_param('society'));
  $phone = sanitize_text_field($request->get_param('phone'));
  $street = sanitize_text_field($request->get_param('street'));
  $zipcode = sanitize_text_field($request->get_param('zipcode'));
  $city = sanitize_text_field($request->get_param('city'));
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
  // save meta
  add_post_meta($post_id, 'title', $title);
  add_post_meta($post_id, 'firstname', $firstname);
  add_post_meta($post_id, 'lastname', $lastname);
  add_post_meta($post_id, 'society', $society);
  add_post_meta($post_id, 'phone', $phone);
  add_post_meta($post_id, 'street', $street);
  add_post_meta($post_id, 'zipcode', $zipcode);
  add_post_meta($post_id, 'city', $city);

  // email
  $from = get_option('gm-contact-from') ?? get_option('admin_email');
  $fromName = get_option('gm-contact-from-name') ?? get_option('admin_email');
  if ($from) {
    // create header
    $headers[] = 'From: ' . $fromName . ' <' . $from . '>';
    // copy
    $headers[] = 'Cc: ' . $email;
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    // subject of email
    $subject = __('Contact message from ', 'gm-contact-form') . get_option('blogname');

    // message html
    $message = "<ul>"
      . "<li><strong>" . __('Date', 'gm-contact-form') . ":</strong><br /> "
      . date('D j M à H:i') . "<br /></li>"
      . "<li><strong>" . __('Email', 'gm-contact-form') . ":</strong><br /> <a href=\"mailto:" . $email . "\">" . $email . "</a><br /></li>"
      . "<li><strong>" . __('Phone', 'gm-contact-form') . ":</strong><br /> "  . $phone . "<br /></li>"
      . "<li><strong>" . __('Title', 'gm-contact-form') . ":</strong><br /> "  . $title . "<br /></li>"
      . "<li><strong>" . __('Lastname', 'gm-contact-form') . ":</strong><br /> "  . $lastname . "<br /></li>"
      . "<li><strong>" . __('Firstname', 'gm-contact-form') . ":</strong><br /> "  . $firstname . "<br /></li>"
      . ($society !== '' ? "<li><strong>" . __('Society', 'gm-contact-form') . ":</strong><br /> "  . $society . "<br /></li>" : '')
      . "<li><strong>" . __('street', 'gm-contact-form') . ":</strong><br /> "  . $street . "<br /></li>"
      . "<li><strong>" . __('Zipcode', 'gm-contact-form') . ":</strong><br /> "  . $zipcode . "<br /></li>"
      . "<li><strong>" . __('City', 'gm-contact-form') . ":</strong><br /> "  . $city . "<br /></li>"
      . "<li><strong>" . __('Message', 'gm-contact-form') . ":</strong><br /> "  . $message . "<br /></li>"
      . "</ul>";

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
    // ok :)
    return [
      'error' => false,
      'message' => 'EMAIL_SEND'
    ];
  }
  return [
    'error' => true,
    'message' => 'ERROR'
  ];
}


function get_token(\WP_REST_Request $request)
{
  $tokenReal = \GMContactForm\includes\token\getToken();
  return ['token' => $tokenReal];
}
