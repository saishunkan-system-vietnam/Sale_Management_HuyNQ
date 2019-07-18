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
        <?php
            echo $this->Form->control('name');
        ?>
        <?php if (isset($attrParents)): ?>
            <label>Attribute</label>
            <select name="category">
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
