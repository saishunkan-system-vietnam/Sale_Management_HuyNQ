<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<div class="orders index large-10 medium-10 columns content">
    <h3><?= __('Orders') ?></h3>
    <form id="search_form">
        <div class="row">
            <select name="status" id="status" class="form-control" style="width: 200px; float:left; margin-right: 10px;">
                <option selected disabled hidden>-- Choose type status --</option>
                <option value="1">Not Processing</option>
                <option value="2">Processing</option>
                <option value="3">Successfull</option>
                <option value="4">Cancel</option>
            </select>
            <input type="text" name="data" style="width: 250px; float: left; margin-right: 10px;" placeholder="Enter something ...">
            <button type="button" id="btn_search" class="btn btn-primary">Search</button>
        </div>  
    </form>
    <table cellpadding="0" cellspacing="0" id="order_table">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('note') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $this->Number->format($order->id) ?></td>
                <td><?= $order->has('user') ? $this->Html->link($order->user->name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                <td><?= $this->Status->checkStatus($order->status) ?></td>
                <td><?= h($order->note) ?></td>
                <td>0<?= $order->phone ?></td>
                <td><?= h($order->address) ?></td>
                <td><?= h($order->email) ?></td>
                <td><?= $this->Number->format($order->total) ?></td>      
                <td><?= h($order->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View Detail'), ['action' => 'view', $order->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
<?= $this->Html->script('order.js') ?>
