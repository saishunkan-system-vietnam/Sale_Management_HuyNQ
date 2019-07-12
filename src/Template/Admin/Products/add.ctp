<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
        <li class="heading"><?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('price');
            echo $this->Form->control('quantity');
            echo $this->Form->control('description');
        ?>
        <div class="row" style="border: 1px solid black;">
            <div>
                <?php
                foreach ($attributes as $attribute) {
                ?>
                    <div class="form-group" style="width: 45%; float: left; margin: 5px;">
                        <label><?= $attribute['name'] ?></label>
                        <select class="form-control" name="<?= $attribute['id'].'_'.str_replace(' ','',$attribute['name']) ?>">
                        <?php 
                        foreach ($attribute['options'] as $attr) {                            
                        ?>
                            <option value=<?= $attr['id'] ?>><?= $attr['name'] ?></option>
                        <?php
                        }
                        ?>         
                      </select>
                    </div>
                <?php
                }
                ?>  
           </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
