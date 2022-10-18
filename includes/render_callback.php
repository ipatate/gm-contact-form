<?php

namespace GMContactForm\includes\renderCallback;

function render_callback($attributes, $content)
{
  $token = \GMContactForm\includes\token\getToken();

  return     '<script type="text/javascript">
	var gmContactFormSuccessMessage =
		"' .   __("The message was sent successfully. Thank you", "gm-contact-form")  . ' ";
	var gmContactFormErrorMessage =
		"' .   __("Oh ! An error occurred while processing your request 😱", "gm-contact-form")  . ' ";
</script>
<div class="gm-contact-form">
	<form action="#" id="gm-contact-form">
		<input type="hidden" name="token" value="" />
		<label for="email"
			>' .   __("Email", "gm-contact-form")  . '
			<input type="email" name="email" id="email" value="" required />
		</label>
    <label for="name"
      >' .   __("Name", "gm-contact-form")  . '
      <input type="text" name="name" id="name" value="" required />
    </label>
    <label for="message"
      >' .   __("Message", "gm-contact-form")  . '
      <textarea name="message" id="message" rows="7" required></textarea>
    </label>
		<label for="beer" class="inline-field beer-field"
			>' .   __("Don't check this box, it's for robot", "gm-contact-form")  . '
			<input type="checkbox" name="beer" id="beer" />
		</label>
		<input
			type="submit"
			id="gm-contact-form-submit"
			value="' .   __("Send", "gm-contact-form")  . ' "
		/>
		<div
			id="gm-contact-form-status"
			class="gm-contact-form-status gm-contact-form-status-hidden"
		>
			<div
				id="gm-contact-form-success"
				class="gm-contact-form-success gm-contact-form-modal gm-contact-form-modal-hidden"
			>
				' . file_get_contents(dirname(__FILE__) . "/../assets/check.svg")  . '
				<span class="gm-message"></span>
			</div>
			<div
				id="gm-contact-form-error"
				class="gm-contact-form-error gm-contact-form-modal gm-contact-form-modal-hidden"
			>
				<span class="gm-message"></span>
			</div>
		</div>
	</form>
</div>';
}
