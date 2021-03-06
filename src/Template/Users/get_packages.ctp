<div style="padding: 10px">
	<div class="row">
		<div class="col-sm-4">
			<div class="card">
				<div class="card-body">
					<button class="btn btn-primary" data-toggle="modal" data-target="#requestPackageModal">Request Package</button>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<table class="table">
				<thead>
					<tr>
						<th>Package Name</th>
						<th>Activation Code</th>
						<th>Available</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($user_packages) > 0): ?>
						<?php foreach ($user_packages as $package): ?>
						
						<tr>
							<td><?= $package->package->name ?></td>
							<td><?= $package->activation_code ?></td>
							<td><?= $package->is_used ? 'No' : 'Yes' ?></td>
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
<div class="modal" tabindex="-1" role="dialog" id="requestPackageModal">
    <?= $this->Form->create(null, ['url' => ['controller' => 'PackageRequests', 'action' => 'add']]) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->input('package_id', ['type' => 'select', 'empty' => 'Please select a package', 'options' => $packages, 'label' => 'Please select a package', 'class' => 'custom-select', 'required']) ?>
                <div>
                	<p>Package Specifics</p>
                	<p>Quantity: <span class="quantity"></span></p>
                	<p>Price: <span class="price"></span></p>
                </div>
                <?= $this->Form->input('bank_reference', ['type' => 'text', 'class' => 'form-control', 'required', 'label' => 'Deposit Reference #']) ?>
                
                <p class="font-italic mb-0">Account name: Captcha Philippines</p>
				<p class="font-italic mb-0">UnionBank</p>
				<p class="font-italic mb-0">Account#: 109420320753</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Request</button>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#package-id').on('change', function () {
			$.ajax({
				headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: url + 'packages/view/' + $(this).val(),
                dataType: 'json',
                success: function (data) {
                	$('.price').text(data.price);
                	$('.quantity').text(data.qty);
                },
                error: function (err) {
                	console.log(err.responseText);
                }
			});
		});
	});
</script>