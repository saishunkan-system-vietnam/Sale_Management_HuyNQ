<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
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
<div class="products form large-10 medium-10 columns content">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <legend><?= __('Edit Product') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('price');
            echo $this->Form->control('quantity');
        ?>
        <div>
            <label>Description</label>
            <textarea name="description" class="ckeditor" id="editor"><?= h($product->description) ?></textarea>
        </div> 
        <br>
        <div class="row">
            <?php if($product['status'] == 1) { ?>
                <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
            <?php }else{ ?>
                <label class="radio-inline"><input type="radio" name="status" value="1">Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0" checked>Private</label>
            <?php } ?>
        </div>

        <div class="row"> 
            <label for="name">Category</label>
            <div class="col-md-6">  
                <select id="categoryParent">
                    <?php foreach ($categories as $category) { 
                        if($category['id'] == $product['category_parent']){
                    ?>
                        <option selected value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                    <?php 
                        }else{
                    ?>
                        <option value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                    <?php        
                        }
                    } 
                    ?>  
                </select>
            </div>

            <div class="col-md-6">
                <?php foreach ($categories as $category){ 
                    if($category['id'] == $product['category_parent']){
                ?>      
                    <select name="category" id="categoryChild">
                        <?php foreach ($category['options'] as $cate) { 
                            if($cate['id'] == $product['category_id']){
                        ?>
                            <option class="opt" selected value=<?= $cate['id'] ?>><?= $cate['name'] ?></option>
                        <?php 
                            }else{
                        ?>
                            <option class="opt" value=<?= $cate['id'] ?>><?= $cate['name'] ?></option>
                        <?php        
                            }
                        } 
                        ?>  
                    </select>
                <?php } } ?>
            </div>

        </div>

        <fieldset>
            <legend>Options</legend>   
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
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('product.js') ?>