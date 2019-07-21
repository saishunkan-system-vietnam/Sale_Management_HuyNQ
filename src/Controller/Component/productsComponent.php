<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use DateTime;

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

    // public function selectAttributes(){
    //     $attributes = $this->ProductAttributes->find('all')
    //                 ->select($this->Products)
    //                 ->select($this->Attributes)
    //                 ->select($this->ProductAttributes)
    //                 ->join([
    //                     'attributes' => [
    //                         'table' => 'attributes',
    //                         'type' => 'INNER',
    //                         'conditions' => 'attributes.id = productattributes.attribute_id'
    //                     ]
    //                 ])
    //                 ->join([
    //                     'products' => [
    //                         'table' => 'products',
    //                         'type' => 'RIGHT',
    //                         'conditions' => 'products.id = productattributes.product_id'
    //                     ]
    //                 ]);
    //     return $attributes;
    // }

    public function selectCategories(){
        $products = $this->Products->find('all')
                    ->select($this->Products)
                    ->select($this->Categories)
                    ->join([
                        'categories' => [
                            'table' => 'categories',
                            'type' => 'INNER',
                            'conditions' => 'categories.id = products.category_id'
                        ]
                    ]);
        return $products;                    
    }

    public function add($reqProduct){
        $query = $this->Products->query();

        $result = $query->insert(['user_id', 'name','price','quantity','description','category_id','status','created','modified'])
        ->values([
            'user_id' => $reqProduct['user_id'],
            'name' => $reqProduct['name'],
            'price' => $reqProduct['price'],
            'quantity' => $reqProduct['quantity'],
            'description' => $reqProduct['description'],
            'category_id' => $reqProduct['category_id'],
            'status' => $reqProduct['status'],
            'created' => $reqProduct['created'],
            'modified' => $reqProduct['modified']
        ])
        ->execute();

        return $result;
    }

    public function update($reqProduct){
        $query = $this->Products->query();
        $query->update()
        ->set(['name' => $reqProduct['name'],'price' => $reqProduct['price'],'quantity' => $reqProduct['quantity'],'description' => $reqProduct['description'],'category_id' => $reqProduct['category'],'status' => $reqProduct['status'],'user_id' => $reqProduct['user_id'],'created' => new DateTime('now'),'modified' => new DateTime('now')])
        ->where(['id' => $reqProduct['id']])
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
