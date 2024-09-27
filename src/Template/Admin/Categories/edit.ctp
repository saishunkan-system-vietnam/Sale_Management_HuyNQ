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
<div class="categories form large-10 medium-10 columns content">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <legend><?= __('Edit Category') ?></legend>
        <div class="input text">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $category['name'] ?>">
            <?php if (isset($errname) ): ?>
                <p class="error" style="color: red;"><?= $errname ?></p>
            <?php endif ?>
        </div>
 
        <div class="row">
            <?php if($category['status'] == 1) { ?>
                <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
            <?php }else{ ?>
                <label class="radio-inline"><input type="radio" name="status" value="1">Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0" checked>Private</label>
            <?php } ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('category.js') ?>