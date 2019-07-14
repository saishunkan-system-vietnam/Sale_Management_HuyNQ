<div class="">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('price');
        echo $this->Form->control('quantity');
        echo $this->Form->control('description');
        ?>
        <div class="row">
            <fieldset>
                <legend><?= __('Options') ?></legend>
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
            </fieldset>
        </div>
        <div class="form-group">
            <label for="">Category</label>
            <select class="form-control" style="width: 50%;" name="category">
                <?php foreach ($categories as $category) { ?>
                    <option><?= $category['name'] ?></option>
                <?php } ?>
            </select>
        </div>  
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>