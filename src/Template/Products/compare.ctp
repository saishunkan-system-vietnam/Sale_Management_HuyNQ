<div class="row">
	<?php if ($compare !== null) { ?>
		<?php foreach ($compare as $key => $product): ?>
			<div class="col-md-6 product">
				<h3 style="float: left; margin-right:10px;"><?= $product['name'] ?></h3>
				<a class="btn btn-default btn_del" product_id="<?= $product['id'] ?>">
		          <i class="fa fa-trash" aria-hidden="true"></i> Delete 
		        </a>
				<table class="shopping-cart-table table">
					<?php foreach ($product['attributes'] as $attribute): ?>
						<tr>
							<th scope="row"><?= $attribute->parentName ?></th>
							<td><?= $attribute->name ?></td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
		<?php endforeach ?>
	<?php }else{ ?>
		<h3>Not product to compare</h3>
	<?php } ?>
</div>	
<?= $this->Html->script('home.js') ?>