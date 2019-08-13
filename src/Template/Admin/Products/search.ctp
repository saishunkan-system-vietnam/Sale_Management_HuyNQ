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
    <td><?= h($product->Categories['name']) ?></td>
    <td><?= h($product->created) ?></td>
    <td><?= h($product->modified) ?></td>
    <td class="actions">
        <?php if($product->status == 1){ ?>
        <?= $this->Html->link(__('View'), ['action' => 'view', $product->id]) ?>
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
        <?= $this->Html->link(__('Sale'), ['action' => 'sale', $product->id]) ?>
        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
        <?php }else{ ?> 
        <?= $this->Html->link(__('Restore'), ['action' => 'restore', $product->id], ['confirm' => __('Are you sure you want to restore # {0}?', $product->id)]) ?>
        <?php } ?>
    </td>
</tr>
<?php endforeach; ?>