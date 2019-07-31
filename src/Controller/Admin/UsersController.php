<?php
namespace App\Controller\Admin;

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
    private $connection;
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
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("admin");
        $this->loadComponent('users');
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
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('user', $user);
    }

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
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $request = $this->request->getData();
            $validation = $this->Users->newEntity($request,['validate' => 'add']);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
                $session->write('User', $request);
            }else{
                $request['password'] = md5($request['password']);
                if($request['type'] == 1){
                    $request['notice'] = "admin";
                }else{
                    $request['notice'] = "user";
                }

                $result = $this->Users->query()->insert(['email', 'password','type','status','notice','created','modified'])
                    ->values([
                        'email' => $request['email'],
                        'password' => $request['password'],
                        'type' => $request['type'],
                        'status' => $request['status'],
                        'notice' => $request['notice'],
                        'created' => new DateTime('now'),
                        'modified' => new DateTime('now')
                    ])
                    ->execute();

                if ($result) {
                    $session->delete('User');
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }      
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
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
        $user = $this->Users->get($id);
        $request = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $validation = $this->Users->newEntity($request);
            $request['id'] = $id;
            $result = $this->users->update($request);
            if ($result) {
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
        $query = $this->Users->query();
        $result = $query->update()
        ->set(['status' => 0,'modified' => new DateTime('now')])
        ->where(['id' => $id])
        ->execute();

        if ($result) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function restore($id = null)
    {
        $query = $this->Users->query();
        $result = $query->update()
        ->set(['status' => 1,'modified' => new DateTime('now')])
        ->where(['id' => $id])
        ->execute();

        if ($result) {
            $this->Flash->success(__('The user has been restored.'));
        } else {
            $this->Flash->error(__('The user could not be restored. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function searchType(){
        $this->viewBuilder()->autoLayout(false);
        $request = $this->getRequest()->getData();
        $users = $this->Users->find()->where(['type'=>$request['type']])->toArray();
        $this->set(compact('users'));
    }

    public function search(){
        $this->viewBuilder()->autoLayout(false);
        $request = $this->getRequest()->getData();
        if($request['data'] !== ""){
            $users = $this->paginate($this->Users->find()->where(['OR'=>[['name LIKE' => '%' . $request['data'] . '%'],
                                                                           ['email LIKE' => '%' . $request['data'] . '%'],
                                                                           ['address LIKE' => '%' . $request['data'] . '%']]]));            
        }
        $this->set(compact('users'));
    }

    public function login()
    {   
        $user = $this->Users->newEntity();
        $this->viewBuilder()->layout("login");
        if($this->Auth->user('id')){
            $this->Flash->error(_('You are already logged in !'));
            return $this->redirect(['action' => 'index']);
        }else {
            if ($this->request->is('post')) {
                $request = $this->getRequest()->getData();
                $user = $this->Users->find()                 
                ->where(['email' => $request['email']])
                ->where(['password' => md5($request['password'])])
                ->first(); 
                if ($user) {
                    if($user['type'] == 1 && $user['status'] == 1){
                        $this->Auth->setUser($user);
                        $this->Flash->success(__('Login successfull !'));
                        return $this->redirect($this->Auth->redirectUrl());
                    }else{
                        $this->Flash->error('You are not permission.');
                    }
                }else{
                    $this->Flash->error('Your email or password is incorrect.');
                }       
            }
            $this->set(compact('user'));
        }
        
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function signup()
    {
        if ($this->request->is('post')) {
            $request = $this->request->getData();
            $validation = $this->Users->newEntity($request);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->success($error);
                    }
                }
            }else{
                $result = $this->connection->execute('INSERT INTO users (email,password,created,modified) VALUES (?,?,?,?)', 
                            [$request['email'], $request['password'],new DateTime('now'),new DateTime('now')],
                            ['string','string','date','date']);
                if ($result) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }      
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }

    public function changePassword($id = null){
        $user = $this->Users->get($id);
        $request = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $validation = $this->Users->newEntity($request,['validate' => 'password']);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }else{
                $request['id'] = $id;
                $result = $this->Users->query()->update()
                ->set(['password' => md5($request['new_password']),'modified' => new DateTime('now')])
                ->where(['id' => $request['id']])
                ->execute();
                if ($result) {
                    $this->Flash->success(__('The Password has been saved.'));
                    return $this->redirect(['action' => 'changePassword', $id]);
                }
                $this->Flash->error(__('The Password could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }
}
