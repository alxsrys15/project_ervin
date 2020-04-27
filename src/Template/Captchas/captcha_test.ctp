<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 20px">
	
	<form action="?" method="POST">
	    <div class="g-recaptcha" data-sitekey="6Lejxu4UAAAAAOW-RaczqQonP_CZGttCAAPwjUND"></div>
			<br/>
			<input type="submit" value="Submit">
	    </form>
	</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#catpcha-form').on('submit', function () {
			$('.btn-submit').addClass('disabled');
		});
	});
</script>

<script type="text/javascript">
      var onloadCallback = function() {
        alert("grecaptcha is ready!");
      };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
      async defer>
    </script>