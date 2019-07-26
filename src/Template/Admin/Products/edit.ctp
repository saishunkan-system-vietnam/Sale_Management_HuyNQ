<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="products form large-10 medium-10 columns content">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <legend><?= __('Edit Product') ?></legend>

        <div class="input text">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $product->name ?>">
            <?php if (isset($errname)): ?>
                <p class="error" style="color: red;"><?= $errname ?></p>
            <?php endif ?>
        </div>

        <div class="input text">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" value="<?= $product->price ?>">
            <?php if (isset($errprice)): ?>
                <p class="error" style="color: red;"><?= $errprice ?></p>
            <?php endif ?>
        </div>

        <div class="input text">
             <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?= $product->quantity ?>">
            <?php if (isset($errquantity)): ?>
                <p class="error" style="color: red;"><?= $errquantity ?></p>
            <?php endif ?>
        </div>
        
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
                <select name="category_id">
                    <?php $this->Select->showCategories($categories,0,'',$category_id); ?>
                </select>
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

        <div>
            <fieldset>
                <legend>Upload Image</legend>
                <form action="/admin/products/image/<?= $product->id ?> " method="post" enctype="multipart/form-data">      
                    <input type="file" multiple name="file[]"/>
                    <input type="submit" class="btn_upload btn btn-primary" value="Submit" name="Submit"/>
                </form>
            </fieldset>
        </div>
        <?php foreach ($images as $image) {
            ?>
            <div class="card col-md-3" style="width: 18rem; height: 282px;">
                <img class="card-img-top" src="/img/<?= $image['name'] ?>" style="height: 258px;" alt="Card image cap">
                <div class="card-body">
        <!--            <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'deleteImage', $image->id], ['confirm' => __('Are you sure you want to delete # {0}?', $image->id)], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php
            } 
        ?>
</div>
<?= $this->Html->script('product.js') ?>