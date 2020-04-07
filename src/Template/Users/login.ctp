<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-sm">     
    </div>
    <div class="col-sm">
      	<div class="card">
  			<div class="card-body">
				<h2 class="text-center">Login</h2>
				<?= $this->Form->create(); ?>
					<div class="form-group">
						<?= $this->Form->input('email', array('class' => 'form-control')); ?>
					</div>
					<div class="form-group">
						<?= $this->Form->input('password', array('type' => 'password', 'class' => 'form-control')); ?>
						<?= $this->Html->link('Forgot password?',  ['controller' => 'Users', 'action' => 'newpassword', '_full' => true]
); ?>
					</div>
					<button type="submit" class="btn btn-primary" style="float: right">LOGIN</button>
				    
				<?= $this->Form->end(); ?>
			</div>
    	</div>
	</div>
    <div class="col-sm">
    </div>
  </div>
</div>
