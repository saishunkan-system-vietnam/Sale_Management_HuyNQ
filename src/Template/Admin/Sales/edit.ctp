<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="sales form large-10 medium-10 columns content">
    <?= $this->Form->create($sale) ?>
    <fieldset>
        <legend><?= __('Edit Sale') ?></legend>
        <div class="form-group input">
                <label>Value:</label>
                <input type="number" name="value" min="0" max="100" value="<?= $sale['value'] ?>" placeholder="Sale Value" />
                <?php if (isset($errvalue)): ?>
                    <p class="error" style="color: red;"><?= $errvalue ?></p>
                <?php endif ?>
            </div>
            <div class="form-group input">
                <label>Start Day:</label>
                <input type="datetime-local" name="startday" id="startday" value="<?= $sale->startday ?>" class="form-control" value="" title="">
                <?php if (isset($errstartday)): ?>
                    <p class="error" style="color: red;"><?= $errstartday ?></p>
                <?php endif ?>
            </div>
            <div class="form-group input">
                <label>End Day:</label>
                <input type="datetime-local" name="endday" id="endday" value="<?= $sale->endday ?>" class="form-control" value="" title="">
                <?php if (isset($errendday)): ?>
                    <p class="error" style="color: red;"><?= $errendday ?></p>
                <?php endif ?>
            </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('product.js') ?>