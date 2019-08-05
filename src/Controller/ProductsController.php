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
    }

    public function index()
    {   
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
        $attributes = $this->attributes->selectAll();
        $categories = $this->Categories->find()->toArray();
        $keyword = $this->request->query('keyword');
        $price = $this->request->query('price');
        // echo "<pre>";
        // print_r($categories);
        // die('a');
        if (!empty($keyword)) {
            $products =$products->where(['products.name LIKE' => '%' . $keyword . '%']);    
        }
        if (!empty($price)) {
            if ($price == 'asc') {
                $products = $products->order(['price' => 'ASC']); 
            }else{
                $products = $products->order(['price' => 'DESC']);
            }
        }
        $products = $this->paginate($products);
        // echo "<pre>";
        // print_r($attributes);
        // die('a');
        $this->set(compact('products','categories','attributes'));       
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

    public function search($category_id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        if($this->request->is('post')){
            $request = $this->request->getData();
            $array = $this->Categories->find()->where(['parent_id'=>$request['category_id']])->toArray();

            if(!empty($array)){
                $data = $this->getChild($array);
                $data = explode(',', $data);
                $data[0] = $request['category_id'];
            }else{
                $data[] = $request['category_id'];
            }

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
            ->group(['products.id'])->where(['products.status'=>1])->where(['products.category_id IN' => $data]);
            $products = $this->paginate($products);
        }
        $this->set(compact('products'));
    }

    public function getChild($array)
    {
      $data = "";
      foreach($array as $key => $element)
      {
        $data = $data.",".$element['id'];
        $result = $this->Categories->find()->where(['parent_id'=>$element['id']])->toArray();
        if(!empty($result))
        {
          $data = $data."".$this->getChild($result);
        }
      }
      return $data;
    }
}
