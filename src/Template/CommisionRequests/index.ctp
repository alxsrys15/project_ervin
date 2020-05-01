
<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>
<div style="margin-top: 70px;">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Date Covered</th>
                        <th>Amount</th>
                        <th>Account Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($commisionRequests) > 0): ?>
                        <?php foreach ($commisionRequests as $commisionRequest): ?>
                        <tr>
                            <td><?= $commisionRequest->user->first_name . ' ' . $commisionRequest->user->last_name ?></td>
                            <td><?= $commisionRequest->date_start . ' - ' . $commisionRequest->date_end ?></td>
                            <td>P <?= number_format($commisionRequest->amount, 2) ?></td>
                            <td><?= $commisionRequest->user->account_number ?></td>
                            <td>
                                <?php if ($commisionRequest->status === "Completed"): ?>
                                    <?= $commisionRequest->status ?>
                                <?php else: ?>
                                    <?= $this->Form->input('status', [
                                        'type' => 'select',
                                        'default' => $commisionRequest->status,
                                        'options' => [
                                            'Pending' => 'Pending',
                                            'Processing' => 'Processing',
                                            'Completed' => 'Completed'
                                        ],
                                        'id' => 'select-status-'.$commisionRequest->id,
                                        'class' => 'custom-select',
                                        'label' => false
                                    ]) ?>    
                                <?php endif ?>   
                            </td>
                            <td>
                                <?php if ($commisionRequest->status !== "Completed"): ?>
                                <button class="btn btn-primary btn-sm btn-save-stat" data-request_id="<?= $commisionRequest->id ?>">Save</button>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="20">
                                No Record Found
                            </td>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.btn-save-stat').on('click', function () {
            var request_id = $(this).data('request_id');
            var stat = $('#select-status-' + request_id).val();
            var td = $('#select-status-' + request_id).parent();
            var parent = $(this).parent();
            $.ajax({
                url: url + 'commision-requests/changeStatus',
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                type: 'post',
                data: {
                    request_id: request_id,
                    status: stat
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#blocker').show();
                },
                success: function (data) {
                    $('#blocker').hide();
                    if (data.success) {
                        alert('Status successfully changed');
                        if (stat === "Completed") {
                            td.html("Completed");
                            parent.html("");
                        }
                    }
                },
                error: function (err) {
                    console.log(err.responseText);
                }
            });
        });
    });