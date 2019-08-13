<div class="">
    <fieldset>
        <legend><?= __('List Product') ?></legend>
        <div class="row">
            <select id="category" class="col-md-4">
                <option selected disabled hidden>-- Choose type category --</option> 
                <?php $this->Select->showCategories($categories); ?>
            </select>

            <div class="col-md-4">
                <input type="text" name="search" id="input_search" value="" style="float: left; width: 300px;margin-right: 10px;" placeholder="Please enter name">
                <button type="button" id="btn_search" class="btn btn-primary">Search</button>
            </div>
        </div>
        <table cellpadding="0" cellspacing="0" style="width: 100%;" id="product_table">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('category') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
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
    <fieldset>
</div>
<?= $this->Html->script('product.js') ?>