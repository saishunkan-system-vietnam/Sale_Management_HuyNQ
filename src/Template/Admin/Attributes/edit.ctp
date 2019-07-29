<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Attribute $attribute
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>

    </ul>
</nav>
<div class="attributes form large-10 medium-10 columns content">
    <?= $this->Form->create($attribute) ?>
    <fieldset>
        <legend><?= __('Edit Attribute') ?></legend>
        <div class="input text">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $attribute['name'] ?>">
            <?php if (isset($errname) ): ?>
                <p class="error" style="color: red;"><?= $errname ?></p>
            <?php endif ?>
        </div>

        <div class="row">
            <?php if($attribute['status'] == 1) { ?>
                <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
            <?php }else{ ?>
                <label class="radio-inline"><input type="radio" name="status" value="1">Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0" checked>Private</label>
            <?php } ?>
        </div>
        
        <?php if (isset($attrParents)): ?>
            <label>Attribute</label>
            <select name="attribute">
                <?php foreach ($attrParents as $attrParent){ 
                    if($attrParent['id'] == $attribute['parent_id']){
                ?>
                    <option selected value=<?= $attrParent['id'] ?>><?= $attrParent['name'] ?></option>
                <?php
                    }else{
                        ?>
                        <option value=<?= $attrParent['id'] ?>><?= $attrParent['name'] ?></option>
                        <?php
                    }
                 } 
                ?>        
            </select>
        <?php endif ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('attribute.js') ?>