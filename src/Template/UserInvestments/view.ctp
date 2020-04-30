<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserInvestment $userInvestment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User Investment'), ['action' => 'edit', $userInvestment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Investment'), ['action' => 'delete', $userInvestment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userInvestment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Investments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Investment'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userInvestments view large-9 medium-8 columns content">
    <h3><?= h($userInvestment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($userInvestment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($userInvestment->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($userInvestment->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($userInvestment->date) ?></td>
        </tr>
    </table>
</div>
