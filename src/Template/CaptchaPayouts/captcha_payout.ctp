<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Self</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $self_count ?></p>
                </div>
            </div>
            <br>
            <a class="btn btn-primary" href="#!" data-toggle="modal" data-target="#payoutModal">New Payout Request</a>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 1st Level</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $first_level_count ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 2nd Level</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $second ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 3rd Level</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $third ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="payoutModal">
    <?= $this->Form->create(null,['url' => ['controller' => 'CaptchaPayouts', 'action' => 'saveRequest']]) ?>
    <?= $this->Form->input('self_count', ['type' => 'hidden', 'value' => $self_count]) ?>
    <?= $this->Form->input('first_level_count', ['type' => 'hidden', 'value' => $first_level_count]) ?>
    <?= $this->Form->input('second_level_count', ['type' => 'hidden', 'value' => $second]) ?>
    <?= $this->Form->input('third_level_count', ['type' => 'hidden', 'value' => $third]) ?>
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
                <button type="submit" class="btn btn-primary">Request</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
            </div>
        </div>  
    </div>
    <?= $this->Form->end() ?>
</div>
