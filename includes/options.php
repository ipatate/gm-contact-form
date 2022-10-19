<?php

namespace GMContactForm\includes\options;

class SettingsPage
{
  public function __construct()
  {
    // Register the settings page.
    add_action('admin_menu', array($this, 'register_settings'));

    // Register the sections.
    add_action('admin_init', array($this, 'register_sections'));

    // Register the fields.
    add_action('admin_init', array($this, 'register_fields'));
  }

  // Register settings.
  public function register_settings()
  {
    add_options_page(
      'GM Form contact Settings', // The title of your settings page.
      'GM Form contact', // The name of the menu item.
      'manage_options', // The capability required for this menu to be displayed to the user.
      'gm-form-contact', // The slug name to refer to this menu by (should be unique for this menu).
      array($this, 'render_settings_page'), // The callback function used to render the settings page.
    );
  }

  // Register sections.
  public function register_sections()
  {
    add_settings_section('gm-form-contact-section', '', array(), 'gm-form-contact');
  }

  // Register fields.
  public function register_fields()
  {
    $fields = array(
      'gm-contact-from' => array(
        'section' => 'gm-form-contact-section',
        'label' => 'Email from',
        'description' => 'Email address sender',
        'type' => 'email',
      ),
      'gm-contact-from-name' => array(
        'section' => 'gm-form-contact-section',
        'label' => 'Name from',
        'description' => 'Name sender',
        'type' => 'text',
      ),
    );
    foreach ($fields as $id => $field) {
      $field['id'] = $id;
      add_settings_field($id, $field['label'], array($this, 'render_field'), 'gm-form-contact', $field['section'], $field);
      register_setting('gm-form-contact', $id);
    }
  }

  // Render individual fields.
  public function render_field($field)
  {
    $value = get_option($field['id']);
    switch ($field['type']) {
      case 'textarea': {
          echo "<textarea name='{$field['id']}' id='{$field['id']}'>$value</textarea>";
          break;
        }
      case 'checkbox': {
          echo "<input type='checkbox' name='{$field['id']}' id='{$field['id']}' " . ($value === '1' ? 'checked' : '') . " />";
          break;
        }
      case 'wysiwyg': {
          wp_editor($value, $field['id']);
          break;
        }
      case 'select': {
          if (is_array($field['options']) && !empty($field['options'])) {
            echo "<select name='{$field['id']}' id='{$field['id']}'>";
            foreach ($field['options'] as $key => $option) {
              echo "<option value='$key' " . ($value === $key ? 'selected' : '') . ">$option</option>";
            }
            echo "</select>";
          }
          break;
        }
      default: {
          echo "<input name='{$field['id']}' id='{$field['id']}' type='{$field['type']}' value='{$value}' />";
          break;
        }
    }

    if (isset($field['description'])) {
      echo "<p class='description'>{$field['description']}</p>";
    }
  }

  // Render the settings page.
  public function render_settings_page()
  {
    echo "<div class='wrap'>";
    echo "<h1>GM Form contact Settings</h1>";
    settings_errors();
    echo "<form method='POST' action='options.php'>";
    settings_fields('gm-form-contact');
    do_settings_sections('gm-form-contact');
    submit_button();
    echo "</form>";
    echo "</div>";
  }
}
