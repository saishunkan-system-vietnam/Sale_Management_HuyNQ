<?php foreach ($users as $user): ?>
    <tr>
        <td><?= $this->Number->format($user->id) ?></td>
        <td><?= h($user->email) ?></td>
        <td><?= h($user->name) ?></td>
        <td><?= h($user->phone) ?></td>
        <td><?= h($user->address) ?></td>
        <td>
            <?php if($user->type == 1){ ?>
                <p style="color: red; text-align: center;">Admin</p>
            <?php }else{ ?>
                <p style="color: green; text-align: center;">User</p>
            <?php } ?>
        </td>
        <td>
            <?php if($user->status == 1){ ?>
                <p style="background-color: green; color: white; text-align: center;">Active</p>
            <?php }else{ ?>
                <p style="background-color: red; color: white; text-align: center;">Deactive</p>
            <?php } ?>
        </td>
        <td><?= h($user->created) ?></td>
        <td><?= h($user->modified) ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
            <?= $this->Html->link(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>