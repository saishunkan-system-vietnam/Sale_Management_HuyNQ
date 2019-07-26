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
        <div class="input text">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value>
            <?php if (isset($errname) && !isset($parent_id)): ?>
                <p class="error" style="color: red;"><?= $errname ?></p>
            <?php endif ?>
        </div>
    </fieldset>
    <div class="row">
        <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
        <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
    </div>
    <br>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<div class="categories form large-6 medium-6 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add Child Category') ?></legend>
        <div class="input text">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value>
            <?php if (isset($errname) && isset($parent_id)): ?>
                <p class="error" style="color: red;"><?= $errname ?></p>
            <?php endif ?>
        </div>

        <div class="input text">
            <select name="parent_id" style="width: 50%">
                    <option value selected hidden>---- Choose type category ----</option> 
                <?php foreach ($cateParents as $cateParent): ?>
                    <option value=<?= $cateParent['id'] ?>><?= $cateParent['name'] ?></option>
                <?php endforeach ?>       
            </select>
            <?php if (isset($errname) && isset($parent_id)): ?>
                <p class="error" style="color: red;"><?= $errparent_id ?></p>
            <?php endif ?>
        </div>
        
        <div class="row">
            <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
            <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('category.js') ?>