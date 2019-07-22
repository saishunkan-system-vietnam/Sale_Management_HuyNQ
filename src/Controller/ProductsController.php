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
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("home");
        $this->loadComponent('products'); 
        $this->loadComponent('home'); 
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

    public function add2cart(){
        $session = $this->getRequest()->getSession();  
        $request = $this->request->getData();
        $product = $this->Products->find()->where(['id'=>$request['id']])->first();
        $product['image'] = $this->Images->find()->where(['product_id'=>$request['id']])->first()->name;
        $product['quantity'] = 1;
        
        // $session->destroy();
        if($session->read('Cart') == null){
            $session->write('Cart',array($product));
        }else{
            $cart = $session->read('Cart');
            $session->delete('Cart');
            $count = 0;
            foreach ($cart as $value) {

                if($value['id'] == $product['id']){
                    $value['quantity'] = $value['quantity'] + 1;
                    $count++;
                }
            }
            if($count!==0){
                $session->write('Cart', $cart);
            }else{
                array_push($cart,$product);
                $session->write('Cart', $cart);
            }   
        }       

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($session->read('Cart')));  
    }

    public function checkout()
    {
        $cart = [];
        $session = $this->getRequest()->getSession();
        if($session->read('Cart') !== null){
            $cart = $session->read('Cart');
        }
        $this->set(compact('cart'));
    }

    public function order(){
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $cart = $session->read('Cart')
            $request = $this->request->getData();
            
            $this->home->addUser($request);
            
            $user_id = $this->Users->find()->where(['email'=>$request['email']])->first()->id;

            $this->home->addOrder($cart, $user_id);
        }
    }
}
