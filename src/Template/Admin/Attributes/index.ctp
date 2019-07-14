<div class="container">
	<fieldset>
		<legend>Attributes</legend>
		<?= $this->Form->create() ?>
		<div class="row">
		<?php foreach ($attributes as $attribute) {
			?>	
				<div class="col-md-6">
					<label for="sel1"><?= $attribute['name'] ?></label>
					<select multiple class="col-md-6">
						<?php foreach ($attribute['options'] as $attr) { ?>
							<option><?= $attr['name'] ?></option>
						<?php } ?>
					</select>
					<div class="col-md-6">		
						<input type="text" placeholder="New <?= $attribute['name'] ?>" name="<?= $attribute['id'] ?>_<?= $attribute['name'] ?>">
					</div>
					<br>
				</div>
			<?php
		} ?>
		</div>
		<?= $this->Form->button(__('Submit')) ?>
		<?= $this->Form->end() ?>
	</fieldset>
</div>