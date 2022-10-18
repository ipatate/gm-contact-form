<script type="text/javascript">
  var gmContactFormSuccessMessage = '<?php echo __("The message was sent successfully.Thank you ", "gm-contact-form")  ?> ';
  var gmContactFormErrorMessage = '<?php echo __("Oh! An error occurred while processing your request😱", "gm-contact-form ")  ?> ';
</script>
<div class="gm-contact-form">
  <form action="#" id="gm-contact-form">
    <input type="hidden" name="token" value="" />
    <div class="gm-form-line gm-form-line-radio">
      <label for="wm" class="gm-form-radio"><input type="radio" name="title" id="wm" value="Ms"><span><?php echo __("Ms", "gm-contact-form") ?></span></label>
      <label for="mn" class="gm-form-radio"><input type="radio" name="title" id="mn" value="M" checked><span><?php echo __("M", "gm-contact-form") ?></span></label>
    </div>
    <div class="gm-form-line">
      <label for="firstname">
        <input type="text" class="peer" name="firstname" id="firstname" value="" required />
        <span><?php echo __("Firstname", "gm-contact-form") ?></span>
      </label>
      <label for="lastname">
        <input type="text" class="peer" name="lastname" id="lastname" value="" required />
        <span><?php echo __("Lastname", "gm-contact-form") ?></span>
      </label>
    </div>
    <div class="gm-form-line">
      <label for="society">
        <input type="text" class="peer" name="society" id="society" value="" />
        <span><?php echo __("Society", "gm-contact-form") ?></span>
      </label>
    </div>
    <div class="gm-form-line">
      <label for="email">
        <input type="email" class="peer" name="email" id="email" value="" required />
        <span><?php echo __("Email", "gm-contact-form") ?></span>
      </label>
      <label for="phone">
        <input type="tel" class="peer" name="phone" id="phone" value="" required />
        <span><?php echo __("Phone", "gm-contact-form") ?></span>
      </label>
    </div>
    <div class="gm-form-line">
      <label for="street">
        <input type="text" class="peer" name="street" id="street" value="" />
        <span><?php echo __("Street", "gm-contact-form") ?></span>
      </label>
    </div>
    <div class="gm-form-line">
      <label for="zipcode">
        <input type="text" class="peer" name="zipcode" id="zipcode" value="" required />
        <span><?php echo __("ZipCode", "gm-contact-form") ?></span>
      </label>
      <label for="city">
        <input type="text" class="peer" name="city" id="city" value="" required />
        <span><?php echo __("City", "gm-contact-form") ?></span>
      </label>
    </div>
    <div class="gm-form-line">
      <label for="message">
        <textarea name="message" class="peer" id="message" rows="7" required></textarea>
        <span><?php echo __("Message", "gm-contact-form") ?></span>
      </label>
    </div>
    <label for="beer" class="inline-field beer-field"><?php echo __("Don't check this box, it's for robot", "gm-contact-form") ?>
      <input type="checkbox" name="beer" id="beer" />
    </label>
    <div class="gm-form-line gm-form-line-button">
      <input type="submit" class="wp-block-button__link wp-element-button" id="gm-contact-form-submit" value="<?php echo  __(" Send", "gm-contact-form") ?> " />
    </div>
    <div class="gm-form-line"><br />* <?php echo __('field required', "gm-contact-form"); ?></div>
    <div id="gm-contact-form-status" class="gm-contact-form-status gm-contact-form-status-hidden">
      <div id="gm-contact-form-success" class="gm-contact-form-success gm-contact-form-modal gm-contact-form-modal-hidden">
        <?php echo  file_get_contents(dirname(__FILE__) . "/../assets/check.svg") ?>
        <span class="gm-message"></span>
      </div>
      <div id="gm-contact-form-error" class="gm-contact-form-error gm-contact-form-modal gm-contact-form-modal-hidden">
        <span class="gm-message"></span>
      </div>
    </div>
  </form>
</div>
