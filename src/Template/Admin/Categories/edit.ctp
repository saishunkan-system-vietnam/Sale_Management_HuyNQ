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
        <?php
            echo $this->Form->control('name');
        ?>
        <?php if (isset($cateParents)): ?>
            <label>Category</label>
            <select name="category">
                <?php foreach ($cateParents as $cateParent){ 
                    if($cateParent['id'] == $category['parent_id']){
                ?>
                    <option selected value=<?= $cateParent['id'] ?>><?= $cateParent['name'] ?></option>
                <?php
                    }else{
                        ?>
                        <option value=<?= $cateParent['id'] ?>><?= $cateParent['name'] ?></option>
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
