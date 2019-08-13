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
        $this->Categories->recover();
    }

    public function index()
    { 
        $this->paginate = [
            'maxLimit' => 8
            ];
        $categories = $this->Categories->find()->toArray();
        $data = $this->request->query();
        $category = $this->Categories;
        if (!isset($data['page'])) {
            if (!empty($data)) {
                $category = $this->Categories->find('children', ['for' => $data['category']])->toArray();
                $cate_parent = $this->Categories->find()->where(['id' => $data['category']])->first();
                array_unshift($category, $cate_parent);
                $ids = [];
                foreach ($category as $key => $value) {
                    array_push($ids, $value['id']);
                }
                $category = $this->Categories->find()->where(['id IN' => $ids]);
            }
        }
        $category = $this->paginate($category);
        // echo "<pre>";
        // print_r($descendants->toArray());
        // die('a');
        $this->set(compact('categories','category'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cateParents = $this->Categories->find()->where(['parent_id IS NULL'])->toArray();
        $categories = $this->Categories->find()->toArray();
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
                        'parent_id' => null,
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
        $this->set(compact('cateParents','categories'));
    }

    public function edit($id = null)
    {
        $category = $this->Categories->find()->where(['id'=>$id])->first();
        $this->set(compact('category'));

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
                $request['id'] = $id;
                $descendants = $this->Categories->find('children', ['for' => $request['id']])->toArray();
                $this->connection->begin();
                $this->categories->update($request);
                if (!empty($descendants)) {
                    foreach ($descendants as $key => $value) {
                        $this->Categories->query()->update()
                        ->set(['status' => $request['status']])
                        ->where(['id' => $value['id']])
                        ->execute();
                    }
                }
                
                $result = $this->connection->commit();
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
