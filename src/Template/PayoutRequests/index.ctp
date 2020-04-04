<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <?= $this->Form->input('date_start', ['type' => 'select', 'class' => 'custom-select', 'options' => [0 => 'First Half', 1 => 'Second Half']]) ?>
            </div>
            <!-- <div class="form-group">
                <?= $this->Form->input('date_end', ['type' => 'text', 'class' => 'form-control']) ?>
            </div> -->
            <button class="btn btn-primary">New Payout Request</button>
        </div>
        <div class="col-sm-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Covered</th>
                        <th>Total Captcha</th>
                        <th>Total Referral</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <!-- <div class="row justify-content-center">
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
            </div> -->
        </div>
    </div>
</div>