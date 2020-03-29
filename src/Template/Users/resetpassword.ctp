<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-sm">     
    </div>
    <div class="col-sm">
      	<div class="card">
  			<div class="card-body">
				<h2 class="text-center">Reset Password</h2>
				<?= $this->Form->create(null, array('action' => 'resetpassword', 'id' => 'web-form')); ?>
					<div class="form-group">
						<?= $this->Form->input('Users.email', array('class' => 'form-control')); ?>
					</div>
				    <div class="row" style="margin-left: 235px;">
						<?= $this->Form->submit('Reset Password', array('class' => 'btn btn-primary')); ?>
					</div>
				<?= $this->Form->end(); ?>
			</div>
    	</div>
	</div>
    <div class="col-sm">
    </div>
  </div>
</div>

