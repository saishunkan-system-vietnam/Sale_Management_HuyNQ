
<div class="">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('price');
        echo $this->Form->control('quantity');
        ?>
        <label>Description</label>
        <textarea name="description" class="ckeditor" id="editor"></textarea>
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
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>