<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CommisionRequest $commisionRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Commision Request'), ['action' => 'edit', $commisionRequest->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Commision Request'), ['action' => 'delete', $commisionRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $commisionRequest->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Commision Requests'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Commision Request'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="commisionRequests view large-9 medium-8 columns content">
    <h3><?= h($commisionRequest->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $commisionRequest->has('user') ? $this->Html->link($commisionRequest->user->id, ['controller' => 'Users', 'action' => 'view', $commisionRequest->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($commisionRequest->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($commisionRequest->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Start') ?></th>
            <td><?= h($commisionRequest->date_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date End') ?></th>
            <td><?= h($commisionRequest->date_end) ?></td>
        </tr>
    </table>
</div>
