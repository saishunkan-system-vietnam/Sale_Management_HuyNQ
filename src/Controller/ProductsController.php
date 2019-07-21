<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

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
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->viewBuilder()->layout("home");
        $this->loadComponent('products');   
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

        // echo "<pre>";
        // print_r($products->toArray());
        // echo "</pre>";
        // die('a');

        $this->set(compact('products'));
    }

    public function view($id = null)
    {
        $product = $this->Products->get($id);

        $this->set(compact('product'));
    }

    public function add2cart($id = null){
        if ($this->request->is('ajax')) {
       
        $product = $this->Products->find()->where(['id'=>$id])->first();

        $this->Session->write('id',$id);
        $this->Session->write('product',$product->name);
        $this->Session->write('price',$product->price);
        $this->Session->write('quantity',1);
         }
        // return $this->response
        //     ->withType('application/json')
        //     ->withStringBody(json_encode("aaa"));
    }

    public function checkout()
    {
        if ($this->request->is('post')) {
        }
    }
}
