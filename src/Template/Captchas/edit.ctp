<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Captcha $captcha
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $captcha->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $captcha->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Captchas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="captchas form large-9 medium-8 columns content">
    <?= $this->Form->create($captcha) ?>
    <fieldset>
        <legend><?= __('Edit Captcha') ?></legend>
        <?php
            echo $this->Form->control('date', ['empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('count');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
