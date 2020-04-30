<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserInvestment $userInvestment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List User Investments'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="userInvestments form large-9 medium-8 columns content">
    <?= $this->Form->create($userInvestment) ?>
    <fieldset>
        <legend><?= __('Add User Investment') ?></legend>
        <?php
            echo $this->Form->control('date', ['empty' => true]);
            echo $this->Form->control('amount');
            echo $this->Form->control('user_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
