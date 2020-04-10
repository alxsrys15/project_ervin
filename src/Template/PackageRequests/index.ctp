<div style="padding: 10px">
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<tr>
						<th>Package Name</th>
						<th>User</th>
						<th>Email</th>
						<th>Deposit Reference #</th>
						<th>Quantity</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($packageRequests) > 0): ?>
						<?php foreach ($packageRequests as $package): ?>
						<tr>
							<td><?= $package->package->name ?></td>
							<td><?= $package->user->first_name . ' ' . $package->user->last_name ?></td>
							<td><?= $package->user->email ?></td>
							<td><?= $package->bank_reference ?></td>
							<td><?= $package->qty ?></td>
							<td><?= $package->status ?></td>
							<td>
								<?php if ($package->status !== "Completed"): ?>
									<?= $this->Form->postLink('Send activation code', ['controller' => 'PackageRequests', 'action' => 'sendCode', $package->package->id, $package->user->id, $package->id], ['class' => 'btn btn-primary btn-sm', 'confirm' => 'Send activation code?']) ?>
								<?php endif ?>
							</td>
						</tr>
						<?php endforeach ?>
					<?php else: ?>
						<tr class="text-center">
							<td colspan="20">No results found.</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
			<div class="row justify-content-center">
                <div class="col-12">
                    <nav>
                        <ul class="pagination">
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