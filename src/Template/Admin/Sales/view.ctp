<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sale
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sale'), ['action' => 'edit', $sale->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sale'), ['action' => 'delete', $sale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sale->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sales'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sale'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sales view large-9 medium-8 columns content">
    <h3><?= h($sale->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sale->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value') ?></th>
            <td><?= $this->Number->format($sale->value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Id') ?></th>
            <td><?= $this->Number->format($sale->product_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Startday') ?></th>
            <td><?= h($sale->startday) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Endday') ?></th>
            <td><?= h($sale->endday) ?></td>
        </tr>
    </table>
</div>
