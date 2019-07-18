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
<div class="attributes form large-4 medium-4 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Parent Attribute') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<div class="attributes form large-6 medium-6 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Child Attribute') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
        <select name="attribute" style="width: 50%">
                <option value=null selected hidden>---- Choose type attribute ----</option> 
            <?php foreach ($attrParents as $attrParent): ?>
                <option value=<?= $attrParent['id'] ?>><?= $attrParent['name'] ?></option>
            <?php endforeach ?>       
        </select>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
