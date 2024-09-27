<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sale
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sales'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="sales form large-10 medium-10 columns content">
    <?= $this->Form->create($sale) ?>
    <fieldset>
        <legend><?= __('Add Sale') ?></legend>
        <?php
            echo $this->Form->control('value');
            echo $this->Form->control('product_id');
            echo $this->Form->control('startday', ['empty' => true]);
            echo $this->Form->control('endday', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
