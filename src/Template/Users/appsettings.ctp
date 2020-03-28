<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-sm">     
    </div>
    <div class="col-sm">
      	<div class="card">
  			<div class="card-body">
				<h2 class="text-center">Settings</h2>
				<?= $this->Form->create(); ?>
					<div class="form-group">
						<?= $this->Form->input('captcha_value', array('class' => 'form-control')); ?>
					</div>
					 <div class="form-group">
						<?= $this->Form->input('referral_value', array('class' => 'form-control')); ?>
					 </div>
				    <div class="row" style="margin-left: 235px;">
						<?= $this->Form->submit('Save', array('class' => 'btn btn-primary')); ?>
					</div>
				<?= $this->Form->end(); ?>
			</div>
    	</div>
	</div>
    <div class="col-sm">
    </div>
  </div>
</div>

