<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Attribute $attribute
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Attribute'), ['action' => 'edit', $attribute->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Attribute'), ['action' => 'delete', $attribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Attributes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Attribute'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Attributes'), ['controller' => 'Attributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Attribute'), ['controller' => 'Attributes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Attributes'), ['controller' => 'Attributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Attribute'), ['controller' => 'Attributes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Product Attributes'), ['controller' => 'ProductAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product Attribute'), ['controller' => 'ProductAttributes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="attributes view large-9 medium-8 columns content">
    <h3><?= h($attribute->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($attribute->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Attribute') ?></th>
            <td><?= $attribute->has('parent_attribute') ? $this->Html->link($attribute->parent_attribute->name, ['controller' => 'Attributes', 'action' => 'view', $attribute->parent_attribute->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($attribute->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Attributes') ?></h4>
        <?php if (!empty($attribute->child_attributes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($attribute->child_attributes as $childAttributes): ?>
            <tr>
                <td><?= h($childAttributes->id) ?></td>
                <td><?= h($childAttributes->name) ?></td>
                <td><?= h($childAttributes->parent_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Attributes', 'action' => 'view', $childAttributes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Attributes', 'action' => 'edit', $childAttributes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Attributes', 'action' => 'delete', $childAttributes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childAttributes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Product Attributes') ?></h4>
        <?php if (!empty($attribute->product_attributes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Attribute Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($attribute->product_attributes as $productAttributes): ?>
            <tr>
                <td><?= h($productAttributes->id) ?></td>
                <td><?= h($productAttributes->attribute_id) ?></td>
                <td><?= h($productAttributes->product_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProductAttributes', 'action' => 'view', $productAttributes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProductAttributes', 'action' => 'edit', $productAttributes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProductAttributes', 'action' => 'delete', $productAttributes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productAttributes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
