<div class="container">
	<fieldset>
		<legend>Attributes</legend>
		<?= $this->Form->create() ?>
		<div class="row">
		<?php foreach ($categories as $category) {
			?>	
				<div class="col-md-6">
					<label for="sel1"><?= $category['name'] ?></label>
					<select multiple class="col-md-6">
						<?php foreach ($category['options'] as $cate) { ?>
							<option><?= $cate['name'] ?></option>
						<?php } ?>
					</select>
					<div class="col-md-6">		
						<input type="text" placeholder="New <?= $category['name'] ?>" name="<?= $category['id'] ?>_<?= $category['name'] ?>">
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