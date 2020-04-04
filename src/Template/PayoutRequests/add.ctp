<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PayoutRequest $payoutRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Payout Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payoutRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($payoutRequest) ?>
    <fieldset>
        <legend><?= __('Add Payout Request') ?></legend>
        <?php
            echo $this->Form->control('start_date', ['empty' => true]);
            echo $this->Form->control('end_date', ['empty' => true]);
            echo $this->Form->control('captcha_count');
            echo $this->Form->control('referral_count');
            echo $this->Form->control('total');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
