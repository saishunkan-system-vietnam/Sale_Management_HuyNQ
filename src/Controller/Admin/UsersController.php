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
            $request = $this->request->getData();
            $validation = $this->Users->newEntity($request);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->success($error);
                    }
                }
            }else{
                $result = $this->Users->query()->insert(['email', 'password','created','modified'])
                    ->values([
                        'email' => $request['email'],
                        'password' => $request['password'],
                        'created' => new DateTime('now'),
                        'modified' => new DateTime('now')
                    ])
                    ->execute();

                if ($result) {
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
            $result = $this->connection->execute('UPDATE users SET email=?,password=?,modified=? WHERE id=?', 
                            [$request['email'],$request['password'],new DateTime('now'),$id],
                            ['string','string','date','integer']);
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
        $this->request->allowMethod(['post', 'delete']);
        $result = $this->connection->execute('DELETE FROM users WHERE id = ?',[$id],['integer']);
        if ($result) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
                ->where(['password' => $request['password']])
                ->first();
                if ($user) {
                    $this->Auth->setUser($user);
                    $this->Flash->success(__('Login successfull !'));
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->error('Your email or password is incorrect.');
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
}
