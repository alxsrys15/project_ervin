<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 20px">
	
	<?= $this->Form->create() ?>
	<fieldset>
		<legend><?= __('CakePHP Image Captcha Demo') ?></legend>
		<?php
		echo $this->Form->input('name');
		echo $this->Captcha->create('captcha', [
		'type'=>'image',
		'theme'=>'random', //two themes, "default" and "random",
		'width'=>220,
		'height'=>90,
		]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>

<script type="text/javascript">
	$(document).ready(function () {
		$('#catpcha-form').on('submit', function () {
			$('.btn-submit').addClass('disabled');
		});
	});
</script>

