<?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $this->Number->format($order->id) ?></td>
        <td><?= $order->has('user') ? $this->Html->link($order->user->name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
        <td><?= $this->Status->checkStatus($order->status) ?></td>
        <td><?= h($order->note) ?></td>
        <td>0<?= $this->Number->format($order->phone) ?></td>
        <td><?= h($order->address) ?></td>
        <td><?= h($order->email) ?></td>
        <td><?= $this->Number->format($order->total) ?></td>      
        <td><?= h($order->created) ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View Detail'), ['action' => 'view', $order->id]) ?>
        </td>
    </tr>
    <?php endforeach; ?>