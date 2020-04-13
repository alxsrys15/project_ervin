<?php $this->Form->templates(['inputContainer' => '<div class="form-group">{{content}}</div>']) ?>
<?php 
$dateNow = date('Y-m-d');

$default = strtotime(date('Y-m-d')) <= strtotime(date('Y-m-12')) ? date('Y-m-12') : date('Y-m-26');

?>
<div style="padding: 10px">
    <div class="row mb-2">
        <div class="col-sm-4">
            <?= $this->Form->input('date', ['type' => 'text', 'class' => 'form-control datepicker', 'default' => $default]) ?>
        </div>
    </div>
    <p style="margin: 0"><?= 'Date covered: ' . date('m/d/Y', strtotime($date_start)) . ' - ' . date('m/d/Y', strtotime($date_end))  ?></p>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $total ?></p>
                </div>
            </div>
            <button class="btn btn-primary" data-toggle="modal" data-target="#payoutModal">Request payout</button>
        </div>
        <div class="col-sm-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Captcha Count</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($captcha_records) > 0): ?>
                        <?php foreach ($captcha_records as $c_record): ?>
                            <tr>
                                <td><?= $c_record->date->format('Y-m-d') ?></td>
                                <td><?= $c_record->count ?></td>
                                <td><?= $c_record->status ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="20" class="text-center">No records found.</td>
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

<div class="modal" tabindex="-1" role="dialog" id="payoutModal">
    <?= $this->Form->create(null,['url' => ['controller' => 'CaptchaPayouts', 'action' => 'saveRequest']]) ?>
    <?= $this->Form->input('total', ['type' => 'hidden', 'value' => $total]) ?>
    <?= $this->Form->input('date_start', ['type' => 'hidden', 'value' => $date_start]) ?>
    <?= $this->Form->input('date_end', ['type' => 'hidden', 'value' => $date_end]) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Total amount:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnClose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center> <h1>₱<?= $total ?>.00</h1> </center>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-submit">Request</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
            </div>
        </div>  
    </div>
    <?= $this->Form->end() ?>
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
            beforeShowDay: function(date) {
                return [date.getDate() == 12 || date.getDate() == 26];
            },
            dateFormat: 'yy-mm-dd',
            onSelect: function (date) {
                var selected = date;
                $.ajax({
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    url: url + 'captcha-payouts/captchaPayout',
                    type: 'post',
                    data: {
                        date: date
                    },
                    beforeSend: function () {
                        $('#blocker').show();
                    },
                    success: function (data) {
                        var date = new Date();
                        var mydate = new Date(selected);
                        $('#blocker').hide();
                        $('#tab-content').html(data);
                        $('#date').val(selected);
                        if (date < mydate) {
                            $('.btn-submit').addClass('disabled');
                            $('.btn-submit').addClass('btn-light');
                            $('.btn-submit').removeClass('btn-primary');
                        }
                    }
                })
            }
        });
    });
</script>