<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Add'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
        <li class="heading"><?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <legend><?= __('Edit Product') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('price');
            echo $this->Form->control('quantity');
            echo $this->Form->control('description');
        ?>
        <?php
            foreach ($product['options'] as $option) {
        ?>
                <div class="form-group" style="width: 45%; float: left; margin: 5px;">
                    <label><?= $option['parent_name'] ?></label>
                    <select class="form-control" name="<?= $option['id'].'_'.str_replace(' ','',$option['parent_name']) ?>">
                        <?php 
                        foreach ($option['options'] as $opt) { 
                            if($opt['id'] != $option['id']){                           
                        ?>
                                <option value=<?= $opt['id'] ?>><?= $opt['name'] ?></option>
                        <?php
                            }else{
                        ?>
                                <option selected="selected" value=<?= $option['id'] ?>><?= $option['name'] ?></option>
                        <?php        
                            }
                        }
                        ?>         
                    </select>
                </div>
            <?php
            }
            ?> 
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
