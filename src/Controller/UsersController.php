<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    protected $Users;
    private $Carts;
    private $CartDetails;
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout', 'signup']);
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Carts = TableRegistry::getTableLocator()->get('Carts');
        $this->CartDetails = TableRegistry::getTableLocator()->get('CartDetails');
        $this->connection = ConnectionManager::get('default');
        $this->loadComponent('users');
        $this->loadComponent('home');
    }

    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function profile($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {   
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {

            $request = $this->request->getData();
            $validation = $this->Products->newEntity($request);
            $product   =   $this->Products->patchEntity($product, $request);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->success($error);
                    }
                }
            }else{
                $request['user_id'] = $this->Auth->user('id');
                $product = $this->Products->patchEntity($product, $request);
                if ($this->Products->save($product)) {
                    $this->Flash->success(__('The product has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
        
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $session = $this->getRequest()->getSession(); 
        $carts = $session->read('Cart');
        
        if($this->Auth->user('id')){
            $this->Flash->error(_('You are already logged in !'));
            return $this->redirect(['action' => 'index']);
        }else {
            if ($this->request->is('post')) {
                $request = $this->getRequest()->getData();
                $errors = [];
                if (empty($request['email'])) {
                    $errors['email'] = "email is not empty.";
                }
                if (empty($request['password'])) {
                    $errors['password'] = "password is not empty.";
                }
                if (!empty($request)) {
                    $user = $this->Users->find()                 
                    ->where(['email' => $request['email']])
                    ->where(['password' => md5($request['password'])])
                    ->first();
                    if ($user && empty($errors)) {
                        if($user['type'] == 0 && $user['status'] == 1){
                            $this->Auth->setUser($user);
                            if($carts!==null){
                                $this->users->addCart($user['id'], $carts);
                            }else{
                                $data = $this->users->showSession($user['id']);
                                $session->write('Cart',$data['Cart']);
                                $session->write('Total',$data['Total']);
                            }
                            $this->Flash->success(__('Login successfull !'));    
                        }else{
                            $errors['email'] = "Please create account User to login.";
                        } 
                    }else{
                        $errors['email'] = "Your email or password is incorrect.";
                    }  
                }       
            }
        }
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($errors));  
    }

    public function logout()
    {
        $session = $this->getRequest()->getSession();
        $carts = $session->read('Cart');
        $user_id = $session->read('Auth.User.id'); 
        $this->Flash->success('You are now logged out.');
        if($carts){
            $this->connection->begin();
            $cart_id = $this->Carts->find()->where(['user_id'=>$user_id])->first()['id'];
            if($cart_id !== null){
                $this->CartDetails->query()->delete()
                ->where(['cart_id' => $cart_id])
                ->execute();

                $this->Carts->query()->delete()
                ->where(['id' => $cart_id])
                ->execute();

                $this->users->addCart($user_id, $carts);
            }else{
                $this->users->addCart($user_id, $carts);
            }  
            $this->connection->commit();
            $session->delete('Cart');
            $session->delete('Total');
            $session->delete('Auth.User');
        }
        return $this->redirect($this->Auth->logout());
    }

    public function signup()
    {
        $session = $this->getRequest()->getSession(); 
        $carts = $session->read('Cart');
        
        if ($this->request->is('post')) {
            $request = $this->getRequest()->getData();
            $validation = $this->Users->newEntity($request, ['validate' => 'signup']);
            $err = [];
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $err[$key] = $error;
                    }
                }
            }else{
                $user = $this->home->addUser($request);
                if ($user) {
                $this->Auth->setUser($user);
                    if($carts!==null){
                        $this->users->addCart($user['id'], $carts);
                    }else{
                        $data = $this->users->showSession($user['id']);
                        $session->write('Cart',$data['Cart']);
                        $session->write('Total',$data['Total']);
                    }
                    $this->Flash->success(__('Sign up successfull !'));  
                }else{
                    $this->Flash->success(__('Sign up faild !'));
                }  
            }       
        }
        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($err)); 
    }
}
