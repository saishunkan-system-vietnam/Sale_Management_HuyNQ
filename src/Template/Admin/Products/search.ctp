<div class="">
    <fieldset>
        <legend><?= __('List Product') ?></legend>
        <div class="row">
            <form action="/admin/products/search" method="post">

                <select name="categoryParent" id="categoryParent" style="width: 200px; float: left; margin-right: 10px;">
                    <?php foreach ($categories as $category): ?>
                    <option selected disabled hidden>-- Choose type category --</option> 
                    <option value=<?= $category['id'] ?>><?= $category['name'] ?></option>
                    <?php endforeach ?>
                </select>

                <select name="categoryChild" id="categoryChild" style="width: 250px; float: left; margin-right: 10px;">
                    <option selected disabled hidden>-- Choose type category detail --</option> 
                </select>

                <input type="text" class="" name="name" placeholder="Product Name.." style="width: 300px; margin-right: 10px; float: left;">
                <button type="submit" class="btn btn-primary">Search</button>
            </form> 
        </div>
        <table cellpadding="0" cellspacing="0" style="width: 100%;">
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
                            <?= $this->Html->link(__('View'), ['action' => 'view', $product->id],['class'=>'btn btn-primary']) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id],['class'=>'btn btn-warning']) ?>
                            <?= $this->Html->link(__('Edit Image'), ['action' => 'image', $product->id],['class'=>'btn btn-success']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id],['class'=>'btn btn-danger'], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
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