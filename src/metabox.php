<div class="gm-contact-details">
  <ul>
    <li><strong><?php echo __('Date', 'gm-contact-form'); ?>:</strong>
      <?php echo get_the_date('D j M à H:i'); ?></li>
    <li><strong><?php echo __('Email', 'gm-contact-form'); ?>:</strong>
      <a href="mailto:<?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></a>
    </li>
    <li><strong><?php echo __('Phone', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'phone', true); ?></li>
    <li><strong><?php echo __('Title', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'title', true); ?></li>
    <li><strong><?php echo __('Firstname', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'firstname', true); ?></li>
    <li><strong><?php echo __('Lastname', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'lastname', true); ?></li>
    <li><strong><?php echo __('Society', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'society', true); ?></li>
    <li><strong><?php echo __('Street', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'street', true); ?></li>
    <li><strong><?php echo __('Zipcode', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'zipcode', true); ?></li>
    <li><strong><?php echo __('City', 'gm-contact-form'); ?>:</strong>
      <?php echo get_post_meta($post->ID, 'city', true); ?></li>
    <li><strong><?php echo __('Message', 'gm-contact-form'); ?>:</strong>
      <?php echo $post->post_content; ?></li>
  </ul>
</div>
<style>
  #publishing-action,
  #misc-publishing-actions,
  .postbox-header,
  #postbox-container-1 {
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
</style>
