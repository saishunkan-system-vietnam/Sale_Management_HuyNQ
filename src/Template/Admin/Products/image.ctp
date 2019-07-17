<div>
	<fieldset>
		<legend>Upload Image</legend>
		<form method="post" enctype="multipart/form-data">      
			<input type="file" name="file"/>
			<input type="submit" class="btn btn-primary" value="Submit" name="Submit"/>
		</form>
	</fieldset>
</div>
<?php foreach ($images as $image) {
	?>
	<div class="card col-md-3" style="width: 18rem; height: 282px;">
		<img class="card-img-top" src="/img/<?= $image['name'] ?>" style="height: 258px;" alt="Card image cap">
		<div class="card-body">
<!-- 			<h5 class="card-title">Card title</h5>
			<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
			<?= $this->Form->postLink(__('Delete'), ['action' => 'deleteImage', $image->id], ['confirm' => __('Are you sure you want to delete # {0}?', $image->id)], ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
	<?php
	} 
?>
