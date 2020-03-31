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
				    	<?= $this->Html->link('resetpassword', ['class' => 'nav-link', 'controller' => 'users', 'action' => 'resetpassword']); ?>
					 </div>
				    <div class="row" style="margin-left: 235px;">
						<?= $this->Form->submit('Login', array('class' => 'btn btn-primary')); ?>
					</div>
				<?= $this->Form->end(); ?>
			</div>
    	</div>
	</div>
    <div class="col-sm">
    </div>
  </div>
</div>

