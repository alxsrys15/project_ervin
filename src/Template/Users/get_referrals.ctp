<div style="padding: 10px">
	<div class="row">
		<div class="col-sm-12 form-group">
			<label class="sr-only" for="link">Referral Link</label>
			<input type="text" class="form-control" value="<?= $user->referral_link ?>" readonly id="link">
		</div>
		<div class="col-sm-4">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Total</h5>
					<p class="card-text" style="font-size: 10rem"><?= count($referrals->toArray()) ?></p>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<table class="table">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($referrals->toArray()) > 0): ?>
						<?php foreach ($referrals as $referral): ?>
						<tr>
							<td><?= $referral->first_name ?></td>
							<td><?= $referral->last_name ?></td>
							<!-- <td>
								<button type="button" class="btn btn-primary btn-sm view-btn" data-id="<?= $user->id ?>">View</button>
							</td> -->
						</tr>
						<?php endforeach ?>
					<?php else: ?>
						<tr class="text-center">
							<td colspan="20">No results found.</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
			<div class="row justify-content-center page">
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
<script type="text/javascript">
	$(document).ready(function () {
		$('.btn-generate').on('click', function () {
			if (confirm('Generate new referral link?')) {
				$.ajax({
					url: url + 'users/generateReferralLink',
					dataType: 'json',
					beforeSend: function () {
						$('#blocker').show();
					},
					success: function (data) {
						$('#blocker').hide();
						if (data.success) {
							$('#link').val(data.token);
						} else {
							alert('Something went wrong');
						}
					},
					error: function (err) {
						('#blocker').hide();
						alert('Something went wrong');
					}
				});
			}
		});
	});
</script>