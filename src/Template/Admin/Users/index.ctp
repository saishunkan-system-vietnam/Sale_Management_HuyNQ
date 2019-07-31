<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="container users index large-12 medium-12 columns content">
    <h3><?= __('Users') ?></h3>
    <div class="col-md-4">
        <select name="type" id="type">
            <option selected disabled hidden>-- Choose type type account --</option> 
            <option value="1">Admin</option>
            <option value="0">User</option>
        </select>
    </div>
    <div class="col-md-4">
        <input type="text" name="search" id="input_search" value="" style="float: left; width: 300px;margin-right: 10px;" placeholder="Please enter name,address,email">
        <button type="button" id="btn_search" class="btn btn-primary">Search</button>
    </div>
    <table cellpadding="0" cellspacing="0" id="user_table">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
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
                    <?php if($user->status == 1){ ?>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Html->link(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    <?php }else{ ?> 
                        <?= $this->Html->link(__('Restore'), ['action' => 'restore', $user->id], ['confirm' => __('Are you sure you want to restore # {0}?', $user->id)]) ?>
                    <?php } ?>

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
<?= $this->Html->script('user.js') ?>