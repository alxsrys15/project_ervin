
<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>
<div style="margin-top: 70px;">
	 <?= $this->Form->create() ?>
	 <input type="hidden" name="user_id" value="<?= $user_id ?>">
	 	<div class="row">
 		 <div class="col-sm-3">
 		 		<div class="card">
	                <div class="card-body">
	                    <div class="form-group">
	                        <?= $this->Form->input('amount', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required', 'label' => 'Amount']) ?>
	                    </div>
	                    <div class="form-group">
	                        <?= $this->Form->input('reference_number', ['type' => 'text', 'autocomplete' => 'off', 'class' => 'form-control', 'required', 'label' => 'Reference Number']) ?>
	                    </div>
	                </div>
	            </div>
	          	<button type="submit" class="btn btn-outline-primary" style="float: right; margin-top: 7px">Add Investment</button>
 		 </div>
 		<div class="col-sm-8">
 		 	<table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Reference Number</th>
                    </tr>
                </thead>
                <tbody>
                	 <?php if (count($userInvestments) > 0): ?>
		                <?php foreach ($userInvestments as $userInvestments): ?>
		                    <tr>
		                        <td><?= $userInvestments->date ?></td>
		                        <td><?= $userInvestments->amount ?></td>
		                        <td><?= $userInvestments->reference_number ?></td>
		                    </tr>
		                <?php endforeach; ?>
		             <?php endif ?>
                </tbody>
            </table>
 		</div> 
 		<div class="col-sm-1"></div>
 	</div>
</div>
	 <?= $this->Form->end() ?>