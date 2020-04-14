<?php
$this->Form->templates(['inputContainer' => '{{content}}']);
$friday = date('Y-m-d', strtotime('monday this week'));
?>
<div style="padding: 10px">
    <div class="row mb-4">
        <div class="col-sm-4">
            <?= $this->Form->input('date', ['type' => 'text', 'class' => 'form-control datepicker', 'default' => $friday]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 1st Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralFirst ?></p>
                </div>
            </div>
            <br>
            <a class="btn btn-primary" href="#!" data-toggle="modal" data-target="#payoutModal">New Payout Request</a>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 2nd Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralSecond ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 3rd Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralThird ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="payoutModal">
    <?= $this->Form->create(null,['url' => ['controller' => 'PayoutRequests', 'action' => 'add']]) ?>
    <?= $this->Form->input('referral_count', ['type' => 'hidden', 'value' => $referralFirst]) ?>
    <?= $this->Form->input('referral_count_2', ['type' => 'hidden', 'value' => $referralSecond]) ?>
    <?= $this->Form->input('referral_count_3', ['type' => 'hidden', 'value' => $referralThird]) ?>
    <?= $this->Form->input('date_start', ['type' => 'hidden', 'value' => $friday]) ?>
    <?= $this->Form->input('total', ['type' => 'hidden', 'value' => $total]) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <br>
                <h5 class="modal-title">Total amount:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnClose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center> <h1>₱<?= $total ?>.00</h1> </center>
            </div>
            <div class="modal-footer">
                <div class="row" style="width:100%;">
                    <div class="col-sm-12">
                         <p class="font-italic">Note: We accept Unionbank accounts only.</p>
                    </div>
                </div>
                 <div class="row">
                    <button type="submit" class="btn btn-primary btn-submit">Request</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
                </div>
            </div>
        </div>  
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">    
    $(document).ready(function () {
        $('.datepicker').datepicker({
            beforeShowDay: function(date) {
                return [date.getDay() == 1];
            },
            dateFormat: 'yy-mm-dd',
            onSelect: function (date) {
                var selected = date;
                $.ajax({
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    url: url + 'payout-requests/referralPayout',
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
                        $('#date-start').val(selected);
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