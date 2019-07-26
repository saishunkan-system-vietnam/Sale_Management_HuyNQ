<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;


/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    private $Categories;
    private $Products;
    public function initialize()
    {
        parent::initialize();  
        $this->loadComponent('categories');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->viewBuilder()->layout("admin");    
        $this->connection = ConnectionManager::get('default');
    }

    public function index()
    { 
        $cateParents = $this->Categories->find()->where(['parent_id' => 0])->toArray();
        // $cateChilds = $this->categories->selectChild();

        $this->set(compact('cateParents'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cateParents = $this->Categories->find()->where(['parent_id' => 0])->toArray();
        if ($this->request->is('post')) {
            $request = $this->request->getData();
            if(isset($request['parent_id'])){
                $this->set('parent_id',$request['parent_id']);
            }
            $validation = $this->Categories->newEntity($request);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }else{
                if(!isset($request['parent_id'])){
                    $this->Categories->query()->insert(['name', 'parent_id', 'status'])
                    ->values([
                        'name' => $request['name'],
                        'parent_id' => 0,
                        'status' => $request['status']
                    ])
                    ->execute();
                    return $this->redirect(['action' => 'index']);
                }else{
                    $this->Categories->query()->insert(['name', 'parent_id', 'status'])
                    ->values([
                        'name' => $request['name'],
                        'parent_id' => $request['parent_id'],
                        'status' => $request['status']
                    ])
                    ->execute();
                    return $this->redirect(['action' => 'index']);
                }

                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('cateParents'));
    }

    public function edit($id = null)
    {
        $check = $this->categories->checkParent($id);
        if($check == 1){
            $category = $this->Categories->find()->where(['id'=>$id])->first();
            $this->set(compact('category'));
        }else{
            $category = $this->Categories->find()->where(['id'=>$id])->first();
            $cateParents = $this->Categories->find()->where(['parent_id'=>0])->toArray();
            $this->set(compact('category', 'cateParents'));
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();

            $validation = $this->Categories->newEntity($request,['validate' => 'categories']);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }else{
                if($check == 1){  
                    $this->connection->begin();
                    $request['id'] = $id;
                    $request['category'] = 0;
                    $this->categories->update($request);
                            
                    $cateChilds = $this->Categories->find()->where(['parent_id'=>$id])->toArray();
                    foreach ($cateChilds as $cateChild) {
                        $request['id'] = $cateChild['id'];
                        $request['name'] = $cateChild['name'];
                        $request['category'] = $id;
                        $this->categories->update($request);
                    }

                    $result = $this->connection->commit();
                }else{
                    $this->connection->begin();
                    $request['id'] = $id;
                    $this->categories->update($request);
                    $result = $this->connection->commit();
                }
                if($result){
                    $this->Flash->success(__('The category updated.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
    }

    public function view($id = null){  
        $cateChilds = $this->Categories->find()->where(['parent_id'=>$id])->toArray();
    
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($cateChilds));

    }
}
