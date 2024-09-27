<div class="">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <div class="">
            <div class="input text">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?php if(isset($_SESSION['Infor']['name'])){ echo $_SESSION['Infor']['name']; } ?>">
                <?php if (isset($errname)): ?>
                    <p class="error" style="color: red;"><?= $errname ?></p>
                <?php endif ?>
            </div>
            <div class="input text">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" value="<?php if(isset($_SESSION['Infor']['price'])){ echo $_SESSION['Infor']['price']; } ?>">
                <?php if (isset($errprice)): ?>
                    <p class="error" style="color: red;"><?= $errprice ?></p>
                <?php endif ?>
            </div>
            <div class="input text">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?php if(isset($_SESSION['Infor']['quantity'])){ echo $_SESSION['Infor']['quantity']; } ?>">
                <?php if (isset($errquantity)): ?>
                    <p class="error" style="color: red;"><?= $errquantity ?></p>
                <?php endif ?>
            </div>
            <div class="input text">
                <label>Description</label>
                <textarea name="description" class="ckeditor" id="description"><?php if(isset($_SESSION['Infor']['description'])){ echo $_SESSION['Infor']['description']; } ?></textarea>
            </div>
        </div>
        <div class="row"> 
            <label for="name">Category</label>
            <div class="col-md-6 input text">  
                <select name="category_id" id="categories">
                    <option value selected hidden>-- Choose type category --</option> 
                    <?php $this->Select->showCategories($categories,0,'',0,$_SESSION['Infor']['category_id']); ?>
                </select>
                <?php if (isset($errcategory_id)): ?>
                    <p class="error" style="color: red;"><?= $errcategory_id ?></p>
                <?php endif ?>
            </div>

        </div>

        <div class="row">
            <?php if (isset($_SESSION['Infor']['status']) && $_SESSION['Infor']['status'] == 0){ ?>
                <label class="radio-inline"><input type="radio" name="status" value="1">Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0" checked>Private</label>
            <?php }else{ ?>
                <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
            <?php } ?>
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
                                <option value=null <?php if(!isset($_SESSION['Infor'][$attribute['id'].'_'.str_replace(' ','',$attribute['name'])])) {?> selected <?php }?> hidden>---- Choose type <?= $attribute['name'] ?> ----</option> 
                                <?php 
                                foreach ($attribute['options'] as $attr) {                            
                                    ?>
                                    <option <?php if(isset($_SESSION['Infor']) && $_SESSION['Infor'][$attribute['id'].'_'.str_replace(' ','',$attribute['name'])]==$attr['id']) { ?>  selected <?php }?> value=<?= $attr['id'] ?>><?= $attr['name'] ?></option>
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