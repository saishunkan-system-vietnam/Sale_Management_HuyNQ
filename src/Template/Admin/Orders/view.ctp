<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Return'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="orders view large-10 medium-10 columns content">
    <h3><?= h($order->name) ?></h3>
    <table class="vertical-table col-md-5">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $order->has('user') ? $this->Html->link($order->user->name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($order->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($order->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= h($order->note) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($order->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td>0<?= $order->phone ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->format($order->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($order->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($order->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($order->modified) ?></td>
        </tr>
    </table>
    <div class="col-md-5">
        <form action="/admin/orders/edit/<?= $order->id ?>" method="post" accept-charset="utf-8">
            <b>Status</b>
            <div>
                <label class="radio-inline"><input type="radio" name="status" value="0" <?php if($order->status == 0){ echo "checked"; } ?>>No Processing</label>
                <label class="radio-inline"><input type="radio" name="status" value="1" <?php if($order->status == 1){ echo "checked"; } ?>>Processing</label>
                <label class="radio-inline"><input type="radio" name="status" value="2" <?php if($order->status == 2){ echo "checked"; } ?>>Successfull</label>
                <label class="radio-inline"><input type="radio" name="status" value="3" <?php if($order->status == 3){ echo "checked"; } ?>>Cancel</label>
            </div>
            <b>Note</b>
            <textarea name="note" style="height: 200px;"></textarea>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="related col-md-12">
        <h4><?= __('Related Order Details') ?></h4>
        <?php if (!empty($order->order_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
            </tr>
            <?php foreach ($order->order_details as $orderDetails): ?>
            <tr>
                <td><?= h($orderDetails->id) ?></td>
                <td><?= h($orderDetails->product_id) ?></td>
                <td><?= h($orderDetails->name) ?></td>
                <td><?= h($orderDetails->price) ?></td>
                <td><?= h($orderDetails->quantity) ?></td>
                <td><?= h($orderDetails->created) ?></td>
                <td><?= h($orderDetails->modified) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
