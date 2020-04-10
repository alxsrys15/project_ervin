<?php $this->Form->templates(['inputContainer' => '<div class="form-group">{{content}}</div>']) ?>

<div style="padding: 10px">
	<div class="row">
		<div class="col-sm-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addPackageModal">New Package</button>
        </div>
        <div class="col-sm-8">
        	<table class="table">
        		<thead>
        			<tr>
        				<th>Package Name</th>
        				<th>Referral Fee</th>
                        <th>Status</th>
                        <th>Action</th>
        			</tr>
        		</thead>
        		<tbody>
        			<?php if (count($packages) > 0): ?>
        				<?php foreach ($packages as $package): ?>
        				<tr>
        					<td><?= $package->name ?></td>
        					<td><?= $package->referral_multiplier ?></td>
                            <td><?= $package->is_active ? "Active" : "Inactive" ?></td>
                            <td>
                                <?php if ($package->is_active): ?>
                                    <?= $this->Form->postLink('Deactivate', ['controller' => 'Packages', 'action' => 'activatePackage', $package->id], ['class' => 'btn btn-danger btn-sm', 'confirm' => 'Deactivate package?']) ?>
                                <?php else: ?>
                                    <?= $this->Form->postLink('Activate', ['controller' => 'Packages', 'action' => 'activatePackage', $package->id, 1], ['class' => 'btn btn-success btn-sm', 'confirm' => 'Activate package?']) ?>
                                <?php endif ?>
                            </td>
        				</tr>
        				<?php endforeach ?>
        			<?php else: ?>
        				<tr>
        					<td colspan="20" class="text-center">No results found</td>
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
<div class="modal" tabindex="-1" role="dialog" id="addPackageModal">
    <?= $this->Form->create(null, ['url' => ['controller' => 'Packages', 'action' => 'add']]) ?>
    <?= $this->Form->input('user_id', ['type' => 'hidden']) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->input('name', ['type' => 'text', 'class' => 'form-control', 'required']) ?>
                <?= $this->Form->input('referral_multiplier', ['type' => 'number', 'class' => 'form-control', 'required', 'Referral Fee', 'required']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>