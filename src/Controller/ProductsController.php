<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;

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
    private $Orders;
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Orders = TableRegistry::getTableLocator()->get('Orders');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes = TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("home");
        $this->loadComponent('products'); 
        $this->loadComponent('attributes'); 
        $this->loadComponent('home'); 
        $this->Categories->recover();
    }

    public function index()
    {   
        $session = $this->getRequest()->getSession();
        // $session->delete('Compare');
        $compare = $session->read('Compare');
        $categories = $this->Categories->find()->where(['parent_id IS NULL'])->toArray();
        $prods = $this->Products->find()->where(['status' => 1])->toArray();
        $attributes = $this->attributes->selectAll();
        $this->paginate = [
            'maxLimit' => 8
            ];

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
            ->group(['products.id'])->where(['products.status'=>1]);
        // echo "<pre>";
        // print_r($products->toArray());
        // echo "</pre>";
        // die('a');
        $data = $this->request->query();
        $keyword = $this->request->query('keyword');
        $price = $this->request->query('price');

        if (!empty($keyword)) {
            $products =$products->where(['products.name LIKE' => '%' . $keyword . '%']); 
            $this->set(compact('keyword'));   
        }
        
        if (!empty($price)) {
            if ($price == 'asc') {
                $products = $products->order(['price' => 'ASC']); 
            }else{
                $products = $products->order(['price' => 'DESC']);
            }
            $this->set(compact('price'));
        }

        if (!empty($data['category'])) {
            foreach ($attributes as $key => $attribute) {
                if($attribute['id'] == 6) {
                    unset($attributes[$key]);
                }
            }
            $array = [$data['category']];
            $descendants = $this->Categories->find('children', ['for' => $data['category']]);
            foreach ($descendants as $key => $value) {
                array_push($array, $value->id);
            }
            $products = $products->where(['products.category_id IN' => $array])->group('products.id');
        }

        if (!empty($data)) {
            $removeAttrs = array("keyword","price","category");
            foreach($removeAttrs as $key) {
                unset($data[$key]);
            }
            $options = $data;
            $this->set(compact('options'));
            $check_products = [];
            foreach ($prods as $pro) {
                $check = 0;
                $attribute = []; 
                $result = $this->ProductAttributes->find()->where(['product_id' => $pro['id']])->toArray();
                foreach ($result as $res) {
                    array_push($attribute, $res['attribute_id']);
                }
                foreach ($data as $dt) {
                    if (!in_array($dt, $attribute)) {
                        $check++;
                    }
                }
                if ($check == 0) {
                    array_push($check_products, $pro['id']);
                }
            } 
            if ($check_products !== []) {
                $products = $products->where(['products.id IN' => $check_products]);
            }else{
                $products = $products->where(['products.id' => null]);
            }  
        }

        $products = $this->paginate($products);

        $this->set(compact('products', 'attributes', 'categories', 'compare'));
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

    public function compare()
    {
        $session = $this->getRequest()->getSession();
        $compare = $session->read('Compare'); 
        
        if ($this->request->is(array('ajax'))) 
        {
            $request = $this->request->getData();
            $product = $this->Products->find()->where(['id' => $request['id']])->first();
            $product['attributes'] = array();
            $attributes = $this->ProductAttributes->find()->where(['product_id' => $product['id']])->toArray();
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

            $check = 0;
            $count = 0;
            if ($compare == null) {
                $compare = [];
            } 
            foreach ($compare as $value) {
                if ($value['id'] == $product['id']) {
                    $check ++;
                }
                $count++;
            }
            if ($check == 0 && $count < 2) {
                array_push($compare, $product);
                $session->write('Compare',$compare);
                $message = 0; 
            } elseif ($count >= 2) {
                $message = 1;
            } else {
                $message = 2;
            }
            
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($message));  
        }
        $this->set(compact('compare'));
    }

    public function delcompare()
    {
        if ($this->request->is(array('ajax'))) 
        {
            $session = $this->getRequest()->getSession();
            $request = $this->request->getData();
            $compare = $session->read('Compare');
            $session->delete('Compare');
            foreach ($compare as $key => $value) {
                if ($value['id'] == $request['id']) {
                    unset($compare[$key]);
                }    
            }
            if(!empty($compare)){
               $session->write('Compare',$compare); 
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($session->read('Compare')));   
        }
    }
}
