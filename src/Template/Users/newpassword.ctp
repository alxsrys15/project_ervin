<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-sm">     
    </div>
    <div class="col-sm">
      	<div class="card">
  			<div class="card-body">
				<h2 class="text-center">Reset Password</h2>
				<?= $this->Form->create(); ?>
    				<div class="form-group">
    					<?= $this->Form->input('password', ['type' => 'password', 'autocomplete' => 'off', 'class' => 'form-control' ,'required']) ?>
    					<div class="invalid-feedback password-validate">
          					Password do not match
        				</div>
    				</div>
    				<div class="form-group">
    					<?= $this->Form->input('repassword', ['type' => 'password', 'autocomplete' => 'off', 'class' => 'form-control', 'required', 'div' => false]) ?>
    					<div class="invalid-feedback password-validate">
          					Password do not match
        				</div>
    				</div>
				    <div class="row" style="margin-left: 235px;">
						<?= $this->Form->submit('Confirm', array('class' => 'btn btn-primary')); ?>
					</div>
				<?= $this->Form->end(); ?>
			</div>
    	</div>
	</div>
    <div class="col-sm">
    </div>
  </div>
</div>

<script type="text/javascript">
	function validatePassword () {
		var pass1 = $('#password').val();
		var pass2 = $('#repassword').val();

		if (pass1 !== pass2) {
			$('.password-validate').show();
			$('#password, #repassword').addClass('is-invalid');
			return false;
		}
		return true;
	}

	$(document).ready(function () {
		$('form').on('submit', function () {
			if (!validatePassword()) {
				return false;
			}
		});
	});
</script>