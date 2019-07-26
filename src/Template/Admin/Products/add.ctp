<div class="">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <div class="">
            <div class="input text">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value>
                <?php if (isset($errname)): ?>
                    <p class="error" style="color: red;"><?= $errname ?></p>
                <?php endif ?>
            </div>
            <div class="input text">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" value>
                <?php if (isset($errprice)): ?>
                    <p class="error" style="color: red;"><?= $errprice ?></p>
                <?php endif ?>
            </div>
            <div class="input text">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value>
                <?php if (isset($errquantity)): ?>
                    <p class="error" style="color: red;"><?= $errquantity ?></p>
                <?php endif ?>
            </div>
            <div class="input text">
                <label>Description</label>
                <textarea name="description" class="ckeditor" id="description"></textarea>
            </div>
        </div>
        <div class="row"> 
            <label for="name">Category</label>
            <div class="col-md-6 input text">  
                <select name="category_id" id="categories">
                    <option value selected hidden>-- Choose type category --</option> 
                    <?php $this->Select->showCategories($categories); ?>
                </select>
                <?php if (isset($errcategory_id)): ?>
                    <p class="error" style="color: red;"><?= $errcategory_id ?></p>
                <?php endif ?>
            </div>

        </div>

        <div class="row">
            <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
            <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
        </div>

        <div class="">
            <fieldset>
                <legend><?= __('Options') ?></legend>
                <div>
                    <?php
                    foreach ($attributes as $attribute) {
                        ?>
                        <div class="form-group" style="width: 45%; float: left; margin: 5px;">
                            <label><?= $attribute['name'] ?></label>
                            <select class="form-control" name="<?= $attribute['id'].'_'.str_replace(' ','',$attribute['name']) ?>">
                                <option value=null selected hidden>---- Choose type <?= $attribute['name'] ?> ----</option> 
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
            </fieldset>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('product.js') ?>