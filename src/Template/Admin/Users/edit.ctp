<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Add'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('Change Password'), ['action' => 'changePassword',$user->id]) ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-10 medium-10 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <div class="input text">
            <label for="name">Email</label>
            <input type="text" name="email" id="email" disabled value="<?= $user->email ?>">
        </div>
        <div class="input text">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $user->name ?>">
        </div>
        <div class="input text">
            <label for="name">Phone</label>
            <input type="number" name="phone" id="phone" value="<?= $user->phone ?>">
        </div>
        <div class="input text">
            <label for="name">Address</label>
            <textarea name="address" id="address"><?= $user->address ?></textarea>
        </div>
        <div class="input text">
            <label for="name">Notice</label>
            <input type="text" name="notice" id="notice" value="<?= $user->notice ?>">
        </div>
        <div class="input text">
            <label for="">Type Account</label>
            <?php if($user['type'] == 1) { ?>
                <label class="radio-inline"><input type="radio" name="type" value="1" checked>Admin</label>
                <label class="radio-inline"><input type="radio" name="type" value="0">User</label>
            <?php }else{ ?>
                <label class="radio-inline"><input type="radio" name="type" value="1">Admin</label>
                <label class="radio-inline"><input type="radio" name="type" value="0" checked>User</label>
            <?php } ?>
        </div>
        <br>
        <div class="input text">
            <label for="">Status</label>
            <?php if($user['status'] == 1) { ?>
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
<?= $this->Html->script('user.js') ?>