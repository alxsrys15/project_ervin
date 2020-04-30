
<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>
<div style="margin-top: 70px;">
	 <?= $this->Form->create() ?>
	 	<div class="row">
 		<div class="col-sm-12">
 		 	<table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Reference Number</th>
                        <th>User Id</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
		                <?php foreach ($userInvestments as $userInvestments): ?>
		                    <tr>
		                        <td><?= $userInvestments->date ?></td>
		                        <td><?= $userInvestments->amount ?></td>
		                        <td><?= $userInvestments->reference_number ?></td>
		                        <td><?= $userInvestments->user_id ?></td>
		                        <td><?= $userInvestments->is_active ?></td>
		                        <td>
		                        	<?php if ($userInvestments->is_active !== "Active"): ?>
										<?= $this->Form->postLink('Activate', ['controller' => 'UserInvestments', 'action' => 'activateInvestment',   $userInvestments->id], ['class' => 'btn btn-primary btn-sm', 'confirm' => 'Activate']) ?>
								<?php endif ?></td>
		                    </tr>
		                <?php endforeach; ?>
                </tbody>
            </table>
 		</div> 
 	</div>
	 <?= $this->Form->end() ?>
</div>
