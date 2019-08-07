<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<h3><?= __('Categories') ?></h3>
<div class="categories index large-8 medium-8 columns content">
    <?= $this->Form->create("",["type" => 'get','class' => 'col-md-4']) ?>
        <select id="category" name="category" style="margin-right: 20px;">
            <option selected disabled hidden>-- Choose type category --</option> 
            <?php $this->Select->showCategories($categories); ?>
        </select>
        <button type="submit" class="btn btn-primary">Submit</button>
    <?= $this->Form->end() ?>
    <table cellpadding="0" cellspacing="0" class="col-md-7">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($category as $value): ?>
            <tr>
                <td><?= $this->Number->format($value->id) ?></td>
                <td><?= h($value->name) ?></td>
                <td>
                    <?php if($value->status == 1){ ?>
                        <p style="background-color: green; color: white; text-align: center;">Active</p>
                    <?php }else{ ?>
                        <p style="background-color: red; color: white; text-align: center;">Deactive</p>
                    <?php } ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $value->id], ['class'=>'btn btn-warning']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->Html->script('category.js') ?>
