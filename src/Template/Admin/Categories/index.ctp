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
<div class="categories index large-4 medium-4 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cateParents as $category): ?>
            <tr>
                <td><?= $this->Number->format($category->id) ?></td>
                <td><?= h($category->name) ?></td>
                <td>
                    <?php if($category->status == 1){ ?>
                        <p style="background-color: green; color: white; text-align: center;">Active</p>
                    <?php }else{ ?>
                        <p style="background-color: red; color: white; text-align: center;">Deactive</p>
                    <?php } ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id], ['class'=>'btn btn-warning']) ?>
                    <a category_id="<?= $category->id ?>" class="view btn btn-primary">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="categories index large-6 medium-6 columns content">
    <table cellpadding="0" cellspacing="0" id="cateChild">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<?= $this->Html->script('category.js') ?>
