<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Products Controller
 *
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    private $Products;
    private $Images;
    private $Users;
    private $Attributes;
    private $ProductAttributes;
    private $Categories;
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes = TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("home");
        $this->loadComponent('products'); 
        // $this->loadComponent('home'); 
    }

    public function index()
    {
        $products = $this->Products->find('all')
                    ->select($this->Products)
                    ->select($this->Images)
                    ->join([
                        'images' => [
                            'table' => 'images',
                            'type' => 'LEFT',
                            'conditions' => 'products.id = images.product_id'
                        ]
                    ])
                    ->group(['products.id']);
                    
        $this->set(compact('products'));
    }

    public function view($id = null)
    {
        $product = $this->Products->get($id);
        $attributes = $this->ProductAttributes->find('all')->where(['product_id'=>$id])->toArray();
        $product['attributes'] = array();

        foreach ($attributes as $attribute) {
            if($attribute->attribute_id !== null){
                $attr = $this->Attributes->find('all')->where(['id'=> $attribute->attribute_id])->first();    
                array_push($product['attributes'], $attr);
            }
        }

        foreach ($product['attributes'] as $attribute) {
            if($attribute !== null){
                $attrParent = $this->Attributes->find('all')->where(['id'=> $attribute->parent_id])->first()->name;
                $attribute['parentName'] = $attrParent;
            }
        }

        $images = $this->Images->find()->where(['product_id'=>$id])->toArray();
        if($images == null){
            $images[0]['name'] = "default.png";
        }
        $product['images'] = $images;

        $category = $this->Categories->find()->where(['id'=>$product['category_id']])->first();
        $cateParent = $this->Categories->find()->where(['id'=>$category['parent_id']])->first()->name;
        $category['parentName'] = $cateParent;
        $product['category'] = $category;

        //picked for you
        $moreProduct = $this->Products->find()->where(['id !=' => $id])->limit(4)->toArray();
        foreach ($moreProduct as $value) {
            $value['image'] = $this->Images->find()->where(['product_id'=>$value['id']])->first()['name'];
            if($value['image'] == null){
                $value['image'] = "default.png";
            }
        }

        $this->set(compact('product', 'moreProduct'));
    }

    public function order(){
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $cart = $session->read('Cart');
            $request = $this->request->getData();
            
            $this->home->addUser($request);
            
            $user_id = $this->Users->find()->where(['email'=>$request['email']])->first()->id;

            $this->home->addOrder($cart, $user_id);
        }
    }
}
