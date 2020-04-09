<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Date Covered</th>
                        <th>Self Count</th>
                        <th>Level 1 Count</th>
                        <th>Level 2 Count</th>
                        <th>Level 3 Count</th>
                        <th>Total Amount</th>
                        <th>User Bank Account#</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?= $request->user->first_name . ' ' . $request->user->last_name ?></td>
                                <td><?= $request->date_start->format('Y-m-d') . ' - ' . $request->date_end->format('Y-m-d') ?></td>
                                <td><?= $request->self_count ?></td>
                                <td><?= $request->first_level_count ?></td>
                                <td><?= $request->second_level_count / .5 ?></td>
                                <td><?= $request->third_level_count / .25 ?></td>
                                <td>P <?= $request->total ?></td>
                                <td><?= $request->user->account_number ?></td>
                                <td>
                                    <?php if ($request->status === "Completed"): ?>
                                        <?= $request->status ?>
                                    <?php else: ?>
                                        <?= $this->Form->input('status', [
                                            'type' => 'select',
                                            'default' => $request->status,
                                            'options' => [
                                                'Pending' => 'Pending',
                                                'Processing' => 'Processing',
                                                'Completed' => 'Completed'
                                            ],
                                            'id' => 'select-status-'.$request->id,
                                            'class' => 'custom-select',
                                            'label' => false
                                        ]) ?>    
                                    <?php endif ?>   
                                </td>
                                <td>
                                    <?php if ($request->status !== "Completed"): ?>
                                    <button class="btn btn-primary btn-sm btn-save-stat" data-request_id="<?= $request->id ?>">Save</button>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="20">No results found.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-12">
                    <nav>
                        <ul class="pagination">
                            <?= $this->Paginator->first() ?>
                            <?= $this->Paginator->prev('Previous') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('Next') ?>
                            <?= $this->Paginator->last() ?>
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
            $.ajax({
                url: url + 'captcha-payouts/changeStatus',
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
                        }
                    }
                },
                error: function (err) {
                    console.log(err.responseText);
                }
            });
        });
    });
</script>