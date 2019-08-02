<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartsController extends AppController
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
    }

    public function checkout()
    {
        $cart = [];
        $session = $this->getRequest()->getSession();
        $total = $session->read('Total');
        if($session->read('Cart') !== null){
            $cart = $session->read('Cart');
        }
        $this->set(compact('cart','total'));
    }

    public function add2cart(){
        $session = $this->getRequest()->getSession();  
        $request = $this->request->getData();
        $product = $this->Products->find()->where(['id'=>$request['id']])->first();
        $image_name = $this->Images->find()->where(['product_id'=>$request['id']])->first()['name'];
        if(!empty($image_name)){
            $product['image'] = $image_name;
        }else{
            $product['image'] = "default.png";
        }
        $product['quantity'] = $request['quantity'];
        $count = 0;
        $total = 0;

        // $session->destroy();
        if($session->read('Cart') == null){
            $quantity = 1;
            $session->write('Cart',array($product));
            $session->write('Total', $product['quantity']*$product['price']);
        }else{
            $cart = $session->read('Cart');
            $session->delete('Cart');

            foreach ($cart as $value) {
                
                if($value['id'] == $product['id']){
                    $quantity = $value['quantity'] + $product['quantity'];
                    if($quantity<=5){
                        $value['quantity'] = $quantity;            
                    }
                    $count++;
                }
            }
            if($count != 0){
                $session->write('Cart', $cart);
            }else{
                array_push($cart,$product);
                $session->write('Cart', $cart);
            }
            foreach ($cart as $value) {
                $total = $total + $value['quantity']*$value['price'];
            }
            $session->write('Total', $total);  
        }       

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($quantity));  
    }

    public function del2cart(){
        $session = $this->getRequest()->getSession();
        $product_id = $this->request->getData();
        $cart = $session->read('Cart');
        foreach ($cart as $value) {
            if($value['id'] == $product_id['id']){
                if($value['quantity'] !== 1){
                    $value['quantity'] = $value['quantity'] - 1;
                }

                $total = $session->read('Total');
                $session->delete('Total');
                $total = $total - $value['price'];
                $session->write('Total',$total);
            }
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($session->read('Cart')));
    }
    public function deleteCart(){
        $session = $this->getRequest()->getSession();  
        $product_id = $this->request->getData();
        $cart = $session->read('Cart');
        $i = 0;
      
        foreach ($cart as $value) {
            if($value['id'] == $product_id['id']){
                $session->delete('Cart.'.$i.'');
                $total = $session->read('Total');
                $session->delete('Total');
                $total = $total - $value['price']*$value['quantity'];
                $session->write('Total',$total);
            }
            $i++;
        }
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($session->read('Cart'))); 
    }
}
