<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<?= $this->Form->create(null, ['url' => ['controller' => 'Captchas', 'action' => 'solveCaptcha']]) ?>
<?= captcha_image_html() ?>
<?= $this->Form->input('CaptchaCode', [
    'label' => 'Retype the characters from the picture:',
    'maxlength' => '10',
    'style' => 'width: 270px;',
    'id' => 'CaptchaCode',
]) ?>
<button class="btn btn-primary btn-sm" type="submit">Submit</button>
<?= $this->Form->end() ?>