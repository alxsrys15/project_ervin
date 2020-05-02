<?php
$date = date('Y-m-d', strtotime('wednesday this week'));
if (strtotime('today') > strtotime('wednesday this week') && strtotime('today') < strtotime('sunday this week')) {
	$date = date('Y-m-d', strtotime('sunday this week'));
}
?>

<div style="padding: 10px">
	<div class="row mb-2">
        <div class="col-sm-4">
            <?= $this->Form->input('date', ['type' => 'text', 'class' => 'form-control datepicker', 'readOnly', 'default' => $date]) ?>
        </div>
    </div>
    <p style="margin: 0"><?= 'Date covered: ' . date('m/d/Y', strtotime($start_date)) . ' - ' . date('m/d/Y', strtotime($end_date))  ?></p>
    <div class="row">
    	<div class="col-sm-4">
    		<div class="card">
    			<div class="card-body">
                    <h5 class="card-title">Total Investment</h5>
                    <p class="card-text">P <?= number_format($total, 2) ?></p>
                    <hr />
                    <h5 class="card-title">Total Commission <small style="font-size: 12px">(For the date covered)</small></h5>
                    <p class="card-text">P <?= number_format($total_commission, 2) ?></p>
                </div>
    		</div>
    		<?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
    		<?= $this->Form->input('amount', ['type' => 'hidden', 'value' => $total_commission]) ?>
    		<?= $this->Form->input('date_start', ['type' => 'hidden', 'value' => $start_date]) ?>
    		<?= $this->Form->input('date_end', ['type' => 'hidden', 'value' => $end_date]) ?>
    		<button class="btn btn-primary btn-submit" data-toggle="modal" data-target="#payoutModal">Request payout</button>
    		<?= $this->Form->end() ?>
    	</div>
    	<div class="col-sm-8">
    		<table class="table">
    			<thead>
    				<th align="center">Date</th>
    				<th align="center">Amount</th>
    				<th>Date Approved</th>
    			</thead>
    			<tbody>
    				<?php if (count($investments) > 0): ?>
    					<?php foreach ($investments as $invesment): ?>
    					<tr>
    						<td><?= $invesment->date ?></td>
    						<td><?= $invesment->amount ?></td>
    						<td><?= $invesment->date_approved ?></td>
    					</tr>
    					<?php endforeach ?>
    				<?php else: ?>
    					<td colspan="20" align="center">No Records Found</td>
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

<script type="text/javascript">
	$(document).ready(function () {
		var dateSelected = new Date($('.datepicker').val());
        var date = new Date();
        if (date < dateSelected) {
            $('.btn-submit').addClass('disabled');
            $('.btn-submit').addClass('btn-light');
            $('.btn-submit').removeClass('btn-primary');
        }
		$('.datepicker').datepicker({
			beforeShowDay: function (date) {
				return [date.getDay() === 3 || date.getDay() === 0];
			},
			dateFormat: 'yy-mm-dd',
			onSelect: function (date) {
				var selected = date;
                $.ajax({
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    url: url + 'commision-requests/getCommissions',
                    type: 'post',
                    data: {
                        date: selected
                    },
                    beforeSend: function () {
                        $('#blocker').show();
                    },
                    success: function (data) {
                        $('#blocker').hide();
                        $('#tab-content').html(data);
                        $('#date').val(selected);
                        var date = new Date();
                        var mydate = new Date(selected);
                        if (date < mydate) {
                            $('.btn-submit').addClass('disabled');
                            $('.btn-submit').addClass('btn-light');
                            $('.btn-submit').removeClass('btn-primary');
                        } else {
                        	$('.btn-submit').removeClass('disabled');
                            $('.btn-submit').removeClass('btn-light');
                            $('.btn-submit').addClass('btn-primary');
                        }
                    }
                });
            }
		})
	})
</script>