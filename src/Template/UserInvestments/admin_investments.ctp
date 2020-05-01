
<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>
<div style="margin-top: 70px;">
	 <div class="row">
 		<div class="col-sm-12">
 		 	<table class="table">
                <thead>
                    <tr>
                    	<th>User</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Reference Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
	                <?php if (count($userInvestments) > 0): ?>
		                <?php foreach ($userInvestments as $userInvestment): ?>
	                    <tr>
	                    	<td><?= $userInvestment->user->first_name . ' ' . $userInvestment->user->last_name ?></td>
	                        <td><?= $userInvestment->date ?></td>
	                        <td><?= $userInvestment->amount ?></td>
	                        <td><?= $userInvestment->reference_number ?></td>
	                        <td><?= $userInvestment->is_active ? 'Approved' : 'For Approval' ?></td>
	                        <td>
	                        	<?php if (!$userInvestment->is_active): ?>
									<?= $this->Form->postLink('Approve', ['controller' => 'UserInvestments', 'action' => 'activateInvestment',   $userInvestment->id], ['class' => 'btn btn-primary btn-sm', 'confirm' => 'Approve?']) ?>
							     <?php endif ?>                     
                            </td>
	                    </tr>
		                <?php endforeach; ?>
		            <?php else: ?>
		            	<tr>
		            		<td colspan="20"></td>
		            	</tr>
	                <?php endif ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-12">
                    <nav>
                        <ul class="pagination" id="pagination">
                            <?= $this->Paginator->prev('Previous') ?>
                            <?= $this->Paginator->numbers(['modulus' => 2]) ?>
                            <?= $this->Paginator->next('Next') ?>
                        </ul>
                    </nav>
                </div>
            </div>
 		</div> 
 	</div>
</div>
