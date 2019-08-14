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
			<?php
			echo $this->Form->control('value');
			echo $this->Form->control('startday', ['empty' => true]);
			echo $this->Form->control('endday', ['empty' => true]);
			?>
			<!-- <input type="datetime-local" name="time" id="input" class="form-control" value="" required="required" title=""> -->
		</fieldset>
		<?= $this->Form->button(__('Submit')) ?>
		<?= $this->Form->end() ?>
	<?php }else{ ?>
		<h3>Product availability. Click Sales to check !</h3>
	<?php } ?>
</div>
<?= $this->Html->script('product.js') ?>