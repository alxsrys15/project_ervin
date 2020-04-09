<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Captcha $captcha
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Captcha'), ['action' => 'edit', $captcha->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Captcha'), ['action' => 'delete', $captcha->id], ['confirm' => __('Are you sure you want to delete # {0}?', $captcha->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Captchas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Captcha'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="captchas view large-9 medium-8 columns content">
    <h3><?= h($captcha->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $captcha->has('user') ? $this->Html->link($captcha->user->id, ['controller' => 'Users', 'action' => 'view', $captcha->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($captcha->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Count') ?></th>
            <td><?= $this->Number->format($captcha->count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($captcha->date) ?></td>
        </tr>
    </table>
</div>
