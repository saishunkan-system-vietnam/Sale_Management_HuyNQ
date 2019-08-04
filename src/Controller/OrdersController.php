<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
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
        $this->loadComponent('home'); 
        $this->loadComponent('email'); 
    }
    
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $user = $session->read("Auth.User");
        // echo "<pre>";
        // print_r($user);
        // die('a');
        $this->set(compact('user'));
    }

    public function order(){
        $session = $this->getRequest()->getSession();
        $user = $session->read("Auth.User");

        if ($this->request->is('post')) {
            $request = $this->request->getData();
            $validation = $this->Users->newEntity($request, ['validate' => 'order']);
            if ($validation->getErrors() && !$user) {
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err' . $key . '', $error);
                    }
                }
            } else {
                $session = $this->getRequest()->getSession();
                $cart = $session->read('Cart');
                $user = $session->read('Auth.User');
                $total = $session->read('Total');
                $password = "";
                $request['total'] = $session->read('Total');

                try {
                    $this->connection->begin();
                    if ($user) {
                        if (isset($request['new_address'])) {
                            $request['address'] = $request['new_address'];
                            $this->home->addOrder($request,$cart, $user['id']);
                         } else {
                            $this->home->addOrder($request,$cart, $user['id']);
                        }
                    } else {
                        $request['password'] = rand(000000, 999999);
                        $password = $request['password'];
                        $user = $this->home->addUser($request);
                        $this->home->addOrder($request,$cart, $user['id']);
                    }
                    $this->connection->commit();

                    $this->Flash->success(__('The Order has been sended. Please check email !'));
                    $this->email->sendEmail($user, $cart, $total, $password);
                    $session->delete('Cart');
                    $session->delete('Total');
                    return $this->redirect(['controller'=>'Products','action' => 'index']);
                } catch(\Exception $e) {
                    $this->connection->rollback();
                    $this->Flash->error(__('The Order could not be sended. Please, try again.'));
                }
            }
        }
        $this->set(compact('user'));
    }
}
