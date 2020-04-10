<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Coverage</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?= $request->start_date->format('Y-m-d') . ' - ' . $request->end_date->format('Y-m-d') ?></td>
                                <td>P <?= $request->total ?></td>
                                <td> <?= $request->status ?></td>
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

<!-- <script type="text/javascript">
    $(document).ready(function () {
        $('.btn-save-stat').on('click', function () {
            var request_id = $(this).data('request_id');
            var stat = $('#select-status-' + request_id).val();
            var td = $('#select-status-' + request_id).parent();
            var removeSave = $(this).parent();
            $.ajax({
                url: url + 'payout-requests/changeStatus',
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
                            removeSave.html("");
                        }
                    }
                },
                error: function (err) {
                    console.log(err.responseText);
                }
            });
        });
    });
</script> -->