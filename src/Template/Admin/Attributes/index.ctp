<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Attribute[]|\Cake\Collection\CollectionInterface $attributes
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Attribute'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<h3><?= __('Attributes') ?></h3>
<div class="attributes index large-4 medium-4 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attrParents as $attribute): ?>
            <tr>
                <td><?= $this->Number->format($attribute->id) ?></td>
                <td><?= h($attribute->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $attribute->id], ['class'=>'btn btn-warning']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $attribute->id], ['class'=>'btn btn-danger'], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="attributes index large-6 medium-6 columns content">
    <table cellpadding="0" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Attribute_Parent</th>
                <th scope="col">ID_Parent</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attrChilds as $attribute): ?>
            <tr>
                <td><?= $this->Number->format($attribute->id) ?></td>
                <td><?= h($attribute->name) ?></td>
                <td><?= h($attribute->parent_name) ?></td>
                <td><?= $this->Number->format($attribute->parent_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $attribute->id], ['class'=>'btn btn-warning']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $attribute->id], ['class'=>'btn btn-danger'], ['confirm' => __('Are you sure you want to delete # {0}?', $attribute->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

