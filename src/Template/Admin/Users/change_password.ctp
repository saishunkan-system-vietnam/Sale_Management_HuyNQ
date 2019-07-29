<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'edit',$user['id']]) ?></li>
    </ul>
</nav>
<div class="users form large-10 medium-10 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend>Change Password</legend>
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="input text">
            <label for="">Current Password</label>
            <input type="password" name="current_password">
            <?php if (isset($errcurrent_password)): ?>
                <p class="error" style="color: red;"><?= $errcurrent_password ?></p>
            <?php endif ?>
        </div>
        <div class="input text">
            <label for="">New Password</label>
            <input type="password" name="new_password">
            <?php if (isset($errnew_password)): ?>
                <p class="error" style="color: red;"><?= $errnew_password ?></p>
            <?php endif ?>
        </div>
        <div class="input text">
            <label for="">Confirm Password</label>
            <input type="password" name="confirm_password">
            <?php if (isset($errconfirm_password)): ?>
                <p class="error" style="color: red;"><?= $errconfirm_password ?></p>
            <?php endif ?>
        </div>   
    </fieldset>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('user.js') ?>