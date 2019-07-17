<div class="">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <div class="">
            <?php
            echo $this->Form->control('name');
            echo $this->Form->control('price');
            echo $this->Form->control('quantity');
            ?>
            <div class="input text">
                <label>Description</label>
                <textarea name="description" class="ckeditor" id="description"></textarea>
            </div>
        </div>
        <div class="row"> 
            <label for="name">Category</label>
            <div class="col-md-6">  
                <select id="categoryParent">
                    <option value=null selected disabled hidden>---- Choose type product ----</option> 
                    <?php foreach ($categories as $category) { ?>
                        <option value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                    <?php } ?>  
                </select>
            </div>

            <div class="col-md-6">
                <select name="category" id="categoryChild">
                    <option value=null selected hidden>---- Choose type product ----</option>
                </select>
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