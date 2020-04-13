<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 20px">
	<?= $this->Form->create(null, ['url' => ['controller' => 'Captchas', 'action' => 'solveCaptcha'], 'id' => 'catpcha-form']) ?>
	<?= captcha_image_html() ?>
	<?= $this->Form->input('CaptchaCode', [
	    'label' => 'Retype the characters from the picture:',
	    'maxlength' => '10',
	    'style' => 'width: 270px;',
	    'id' => 'CaptchaCode',
	    // 'class' => 'form-control'
	]) ?>
	<button class="btn btn-primary btn-sm btn-submit" type="submit">Submit</button>
	<?= $this->Form->end() ?>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#catpcha-form').on('submit', function () {
			$('.btn-submit').addClass('disabled');
		});
	});
</script>