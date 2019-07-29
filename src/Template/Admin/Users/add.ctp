<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-10 medium-10 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <div class="input text">
            <label for="name">Email</label>
            <input type="email" name="email" id="email">
            <?php if (isset($erremail)): ?>
                <p class="error" style="color: red;"><?= $erremail ?></p>
            <?php endif ?>
        </div>
        <div class="input text">
            <label for="name">Password</label>
            <input type="password" name="password" id="password">
            <?php if (isset($errpassword)): ?>
                <p class="error" style="color: red;"><?= $errpassword ?></p>
            <?php endif ?>
        </div>
        <div class="input text">
            <label for="">Confirm Password</label>
            <input type="password" name="confirm_password">
            <?php if (isset($errconfirm_password)): ?>
                <p class="error" style="color: red;"><?= $errconfirm_password ?></p>
            <?php endif ?>
        </div>
        <div class="input text">
            <label for="">Type Account</label>
            <label class="radio-inline"><input type="radio" name="type" value="1" checked>Admin</label>
            <label class="radio-inline"><input type="radio" name="type" value="0">User</label>
        </div>
        <br>
        <div class="input text">
            <label for="">Status</label>
            <label class="radio-inline"><input type="radio" name="status" value="1" checked>Public</label>
            <label class="radio-inline"><input type="radio" name="status" value="0">Private</label>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('user.js') ?>
