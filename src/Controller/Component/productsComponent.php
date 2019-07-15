<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ProductsComponent extends Component {
    private $Products;
    private $Attributes;
    private $Images;
    private $ProductAttributes;
    private $Categories;

    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->Categories=TableRegistry::getTableLocator()->get('Categories');

    }

    public function add($reqProduct){
        $query = $this->Products->query();
        $result = $query->insert(['user_id', 'name','price','quantity','description','created','modified'])
        ->values([
            'user_id' => $reqProduct['user_id'],
            'name' => $reqProduct['name'],
            'price' => $reqProduct['price'],
            'quantity' => $reqProduct['quantity'],
            'description' => $reqProduct['description'],
            'created' => $reqProduct['created'],
            'modified' => $reqProduct['modified']
        ])
        ->execute();

        return $result;
    }

    public function update($reqProduct, $id){
        $query = $this->Products->query();
        $query->update()
        ->set(['name' => $reqProduct['name'],'price' => $reqProduct['price'],'quantity' => $reqProduct['quantity'],'description' => $reqProduct['description'],'user_id' => $reqProduct['user_id'],'created' => $reqProduct['created'],'modified' => $reqProduct['modified']])
        ->where(['id' => $id])
        ->execute();
    }

    public function addImage($reqImage){
        $query = $this->Images->query();
        $result = $query->insert(['name', 'product_id'])
        ->values([
            'name' => $reqImage['name'],
            'product_id' => $reqImage['product_id']
        ])
        ->execute();

        return $result;
    }
}
?>
