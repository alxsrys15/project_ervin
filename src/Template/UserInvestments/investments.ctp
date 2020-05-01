<?php $dateNow = date('Y-m-d') ?>
<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>
<div style="margin-top: 70px;">
	<div class="row">
	 	<div class="col-sm-4">
	 		<?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
	 		<?= $this->Form->input('date', ['type' => 'hidden', 'value' => $dateNow]) ?>
	 		<div class="card">
            	<div class="card-body">
                	<div class="form-group">
                    	<?= $this->Form->input('amount', ['type' => 'number', 'autocomplete' => 'off', 'class' => 'form-control', 'required', 'label' => 'Amount', 'min' => 1000, 'oninvalid' => 'this.setCustomValidity("Minimum investment is 1000")']) ?>
                	</div>
	                <div class="form-group">
	                    <?= $this->Form->input('reference_number', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required', 'label' => 'Reference Number']) ?>
	                </div>
            	</div>
        	</div>
      		<button type="submit" class="btn btn-outline-primary" style="float: right; margin-top: 7px">Add Investment</button>
      		<?= $this->Form->end() ?>
	 	</div>
		<div class="col-sm-8">
	 		<table class="table">
       			<thead>
		            <tr>
		                <th>Date</th>
		                <th>Amount</th>
		                <th>Reference Number</th>
		                <th>Status</th>
		            </tr>
        		</thead>
	        	<tbody>
				<?php if (count($userInvestments) > 0): ?>
				    <?php foreach ($userInvestments as $userInvestments): ?>
				        <tr>
				            <td><?= $userInvestments->date ?></td>
				            <td><?= $userInvestments->amount ?></td>
				            <td><?= $userInvestments->reference_number ?></td>
				            <td><?= $userInvestments->is_active ? 'Approved' : 'For Approval' ?></td>
				        </tr>
				    <?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="20">No records found</td>
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
