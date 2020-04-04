<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 1st Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralFirst->toArray() ?></p>
                </div>
            </div>
            <button class="btn btn-primary">New Payout Request</button>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 2nd Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= count($referralSecond->toArray()) ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 3rd Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= count($referralThird->toArray()) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>