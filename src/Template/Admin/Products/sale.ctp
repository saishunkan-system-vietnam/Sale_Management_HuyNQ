<nav class="large-2 medium-2 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?></li>
	</ul>
</nav>
<div class="sales form large-10 medium-10 columns content">
	<?php if (empty($check)) { ?>
		<?= $this->Form->create($sale) ?>
		<fieldset>
			<legend><?= __('Add Sale') ?></legend>
			<div class="form-group input">
			    <label>Value:</label>
			    <input type="number" name="value" min="0" max="100" <?php if (isset($request['value'])): ?> value="<?= $request['value'] ?>" <?php endif ?> placeholder="Sale Value" />
			    <?php if (isset($errvalue)): ?>
                    <p class="error" style="color: red;"><?= $errvalue ?></p>
                <?php endif ?>
			</div>
			<div class="form-group input">
			    <label>Start Day:</label>
			    <input type="datetime-local" name="startday" id="startday" <?php if (isset($request['startday'])): ?> value="<?= $request['startday'] ?>" <?php endif ?> class="form-control" value="" title="">
			    <?php if (isset($errstartday)): ?>
                    <p class="error" style="color: red;"><?= $errstartday ?></p>
                <?php endif ?>
			</div>
			<div class="form-group input">
			    <label>End Day:</label>
			    <input type="datetime-local" name="endday" id="endday" <?php if (isset($request['endday'])): ?> value="<?= $request['endday'] ?>" <?php endif ?> class="form-control" value="" title="">
			    <?php if (isset($errendday)): ?>
                    <p class="error" style="color: red;"><?= $errendday ?></p>
                <?php endif ?>
			</div>
			<div class="form-group">
			    <label>Status:</label>
			    <label class="radio-inline"><input type="radio" name="status" value="1" <?php if (isset($request['status']) && $request['status'] == 1 || empty($request['status'])): ?> checked <?php endif ?>>Public</label>
                <label class="radio-inline"><input type="radio" name="status" value="0" <?php if (isset($request['status']) && $request['status'] == 0): ?> checked <?php endif ?>>Private</label>
			</div>
		</fieldset>
		<?= $this->Form->button(__('Submit')) ?>
		<?= $this->Form->end() ?>
	<?php }else{ ?>
		<h3>Product availability. Click Sales to check !</h3>
	<?php } ?>
</div>
<?= $this->Html->script('product.js') ?>