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
                    ])
                    ->order(['products.id' => 'DESC']);
        return $products;                    
    }

    public function add($reqProduct){
        $product = $this->Products->newEntity();
            $product->user_id = $reqProduct['user_id'];
            $product->name = $reqProduct['name'];
            $product->price = $reqProduct['price'];
            $product->quantity = $reqProduct['quantity'];
            $product->description = $reqProduct['description'];
            $product->category_id = $reqProduct['category_id'];
            $product->status = $reqProduct['status'];
            $product->created = new DateTime('now');
            $product->modified = new DateTime('now');

        $product = $this->Products->save($product);
 

        return $product;
    }

    public function update($reqProduct){
        $query = $this->Products->query();
        $query->update()
        ->set(['name' => $reqProduct['name'],'price' => $reqProduct['price'],'quantity' => $reqProduct['quantity'],'description' => $reqProduct['description'],'category_id' => $reqProduct['category_id'],'status' => $reqProduct['status'],'user_id' => $reqProduct['user_id'],'created' => new DateTime('now'),'modified' => new DateTime('now')])
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

    public function checkImage($reqImage){
        // echo "<pre>";
        // print_r($reqImage);
        // echo "</pre>";
        // die('a');
        $uploadOK = 1;
        $message = "";
        foreach ($reqImage as $key => $value) {
            if ($value["size"] > 500000) {
                $name = $value["name"];
                $message = $message."Sorry, ".$name." is too large.<br>";
                $uploadOK = 0;
            }

            if($value["type"] != "image/jpeg" && $value["type"] != "image/png" && $value["type"] != "image/jpg" && $value["type"] != "") {
                $name = $value["name"];
                $message = $message."Sorry, ".$name." files are not allowed. only JPG, JPEG, PNG & GIF.<br>";
                $uploadOK = 0;
            }
        }

        if($uploadOK == 1){
            return $uploadOK;
        }else{
            return $message;
        }    
    }

    public function checkDate($request)
    {

    }
}
?>
