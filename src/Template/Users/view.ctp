<?php $this->Form->templates(['inputContainer' => '<div class="form-group">{{content}}</div>']) ?>

<div class="container" style="margin-top: 70px">
    <?= $this->Form->create($user) ?>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Profile</h2>
                    <?= $this->Form->input('id', ['type' => 'hidden', 'class' => 'form-control']) ?>
                    <?= $this->Form->input('first_name', ['class' => 'form-control']) ?>
                    <?= $this->Form->input('last_name', ['class' => 'form-control']) ?>
                    <?= $this->Form->input('account_number', ['class' => 'form-control', 'label' => "Unionbank Account Number"]) ?>
                    <?= $this->Form->input('referral_link', ['class' => 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-outline-primary" style="margin-top: 7px">Save</button>
    </div>
    <?= $this->Form->end() ?>
</div>