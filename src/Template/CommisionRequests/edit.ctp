<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CommisionRequest $commisionRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $commisionRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $commisionRequest->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Commision Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="commisionRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($commisionRequest) ?>
    <fieldset>
        <legend><?= __('Edit Commision Request') ?></legend>
        <?php
            echo $this->Form->control('date_start', ['empty' => true]);
            echo $this->Form->control('date_end', ['empty' => true]);
            echo $this->Form->control('amount');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
