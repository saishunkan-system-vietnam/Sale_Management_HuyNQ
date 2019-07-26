<?php foreach ($products as $product): ?>
    <tr>
        <td><?= $this->Number->format($product->id) ?></td>
        <td><?= h($product->name) ?></td>
        <td><?= $this->Number->format($product->price) ?></td>
        <td><?= $this->Number->format($product->quantity) ?></td>
        <td>
            <?php if($product->status == 1){ ?>
                <p style="background-color: green; color: white; text-align: center;">Active</p>
            <?php }else{ ?>
                <p style="background-color: red; color: white; text-align: center;">Deactive</p>
            <?php } ?>
        </td>
        <td><?= h($product->category) ?></td>
        <td><?= h($product->created) ?></td>
        <td><?= h($product->modified) ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $product->id],['class'=>'btn btn-primary']) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id],['class'=>'btn btn-warning']) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id],['class'=>'btn btn-danger'], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
        </td>
    </tr>
<?php endforeach; ?>