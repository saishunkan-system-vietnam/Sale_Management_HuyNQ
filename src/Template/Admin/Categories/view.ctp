<tbody>
    <?php foreach ($cateChilds as $category): ?>
        <tr>
            <td><?= $this->Number->format($category->id) ?></td>
            <td><?= h($category->name) ?></td>
            <td><?= h($category->parent_name) ?></td>
            <td><?= $this->Number->format($category->parent_id) ?></td>
            <td>
                <?php if($category->status == 1){ ?>
                    <p style="background-color: green; color: white; text-align: center;">Active</p>
                <?php }else{ ?>
                    <p style="background-color: red; color: white; text-align: center;">Deactive</p>
                <?php } ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id], ['class'=>'btn btn-warning']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>