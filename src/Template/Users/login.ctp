<?= date('Y-m-d H:i:s') ?>
<div class="container" style="margin-top: 30px;">
  <div class="row">
    <div class="col-sm-12 text-center">
    	<?= $this->Html->image('logo.jpg', ['class' => 'img-thumbnail', 'width' => 200]) ?>
    </div>
    <div class="col-sm-6 offset-sm-3">
      	<div class="card">
  			<div class="card-body">
				<h2 class="text-center">Login</h2>
				<?= $this->Form->create(); ?>
					<div class="form-group">
						<?= $this->Form->input('email', array('class' => 'form-control')); ?>
					</div>
					<div class="form-group">
						<?= $this->Form->input('password', array('type' => 'password', 'class' => 'form-control')); ?>
						
					</div>
					<?= $this->Html->link('Register',  ['controller' => 'Users', 'action' => 'register']); ?>
					<button type="submit" class="btn btn-primary" style="float: right">LOGIN</button>
				    
				<?= $this->Form->end(); ?>
			</div>
    	</div>
	</div>
    <div class="col-sm">
    </div>
  </div>
</div>
