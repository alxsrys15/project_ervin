<?php $this->Form->templates(['inputContainer' => '<div class="form-group">{{content}}</div>']) ?>
<div class="container" style="margin-top: 70px">
    <?= $this->Form->create() ?>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Change Password</h2>
                    <?= $this->Form->input('old_password', ['type' => 'password', 'class' => 'form-control', 'required']) ?>
                    <hr>
                    <?= $this->Form->input('new_password', ['class' => 'form-control', 'required', 'type' => 'password']) ?>
                    <div class="invalid-feedback password-validate">
      					Password do not match
    				</div>
                    <?= $this->Form->input('confirm_password', ['class' => 'form-control', 'required', 'type' => 'password']) ?>
                    <div class="invalid-feedback password-validate">
      					Password do not match
    				</div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-outline-primary" style="margin-top: 7px">Save</button>
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
	function validatePassword () {
		var pass1 = $('#new-password').val();
		var pass2 = $('#confirm-password').val();

		if (pass1 !== pass2) {
			$('.password-validate').show();
			$('#new-password, #confirm-password').addClass('is-invalid');
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