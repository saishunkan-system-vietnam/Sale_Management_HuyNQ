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
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attrParents as $attribute): ?>
            <tr>
                <td><?= $this->Number->format($attribute->id) ?></td>
                <td><?= h($attribute->name) ?></td>
                <td>
                    <?php if($attribute->status == 1){ ?>
                        <p style="background-color: green; color: white; text-align: center;">Active</p>
                    <?php }else{ ?>
                        <p style="background-color: red; color: white; text-align: center;">Deactive</p>
                    <?php } ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $attribute->id], ['class'=>'btn btn-warning']) ?>
                    <a attribute_id="<?= $attribute->id ?>" class="view btn btn-primary">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="attributes index large-6 medium-6 columns content">
    <table id="attrChild" cellpadding="0" cellspacing="0" style="width: 100%;">
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
<?= $this->Html->script('attribute.js') ?>
