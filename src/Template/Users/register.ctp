<?php 
$ref_link = isset($this->request->query['referral']) ? $this->request->query['referral'] : '';
$isExpired = false;

?>

<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>
<div class="container" style="margin-top: 70px;">
	<?php if (!$isExpired): ?>
    <h2>Registration</h2>
    <?= $this->Form->create() ?>
    <input type="hidden" name="ref_link" value="<?= $ref_link ?>">
    <div class="row">
        <div class="col-sm-6">     
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Account Information</h2>
                    <div class="form-group">
                        <?= $this->Form->input('email', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required']) ?>
                    </div>
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
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Personal Information</h2>
                    <div class="form-group">
                        <?= $this->Form->input('first_name', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required']) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('last_name', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required']) ?>
                    </div>
                    
                    <div class="form-group">
                        <?= $this->Form->input('account_number', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'label' => 'Bank Account Number', 'required']) ?>
                    </div>
                    <!-- <div class="form-group">
                        <?= $this->Form->input('reference_number', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required']) ?>
                    </div> -->
                    <div class="form-group">
                        <?= $this->Form->input('bank_name', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required']) ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-outline-primary" style="float: right; margin-top: 7px">Confirm</button>
    <?= $this->Form->end() ?>
    <?php else: ?>
    <div class="text-center">
        <h4>Referral link is already expired. Please generate another link.</h4>
    </div>
    <?php endif ?>
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

