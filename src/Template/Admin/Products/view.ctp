<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Add'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?> </li>  
    </ul>
</nav>
<div class="products view large-10 medium-10 columns content">
    <h3><?= h($product->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $this->Html->link($product->user_id, ['controller' => 'Users', 'action' => 'view', $product->user_id]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($product->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $product->id ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $product->price ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $product->quantity ?></td>
        </tr>
        <?php
            foreach ($product['options'] as $option) {
        ?>
            <tr>
                <th scope="row"><?= $option->parent_name ?></th>
                <td><?= h($option->name) ?></td>
            </tr>
        <?php
            }  
        ?>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($product->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($product->modified) ?></td>
        </tr>
    </table>

    <fieldset>
        <legend>Images</legend>
        <?php foreach ($images as $image) {
        ?>
        <div class="card col-md-3" style="width: 18rem; height: 282px;">
            <img class="card-img-top" src="/img/<?= $image['name'] ?>" style="height: 258px;" alt="Card image cap">
            <div class="card-body">
            <!--    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
            </div>
        </div>
        <?php
        } 
        ?>
    </fieldset>

    <div class="row">
        <fieldset>
            <legend><?= __('Description') ?></legend> 
            <?= $this->Text->autoParagraph(htmlspecialchars_decode($product->description)); ?>
        </fieldset>
    </div>
</div>
