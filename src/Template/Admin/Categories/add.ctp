<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="categories form large-4 medium-4 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Parent Category') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<div class="categories form large-6 medium-6 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Child Category') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
        <select name="category" style="width: 50%">
                <option value=null selected hidden>---- Choose type category ----</option> 
            <?php foreach ($cateParents as $cateParent): ?>
                <option value=<?= $cateParent['id'] ?>><?= $cateParent['name'] ?></option>
            <?php endforeach ?>       
        </select>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
