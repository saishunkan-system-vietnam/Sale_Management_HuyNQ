<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

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

    public function initialize()
    {
        parent::initialize();  
        $this->loadComponent('categories');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->viewBuilder()->layout("admin");    
        $this->connection = ConnectionManager::get('default');
    }

    public function index()
    {
        $cateParents = $this->Categories->find()->where(['parent_id' => 0])->toArray();
        $cateChilds = $this->categories->selectChild();
        // echo "<pre>";
        // print_r($cateChilds);
        // echo "</pre>";
        // die('a');

        $this->set(compact('cateParents','cateChilds'));
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
            // echo "<pre>";
            // print_r($request);
            // echo "</pre>";
            // die('a');
            if(!isset($request['category'])){
                $this->Categories->query()->insert(['name', 'parent_id'])
                ->values([
                    'name' => $request['name'],
                    'parent_id' => 0
                ])
                ->execute();
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Categories->query()->insert(['name', 'parent_id'])
                ->values([
                    'name' => $request['name'],
                    'parent_id' => $request['category']
                ])
                ->execute();
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('cateParents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $check = $this->categories->checkParent($id);
        if($check == 1){
            $category = $this->Categories->find()->where(['id'=>$id])->first();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $request = $this->request->getData();
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
                if($result){
                    $this->Flash->success(__('The category updated.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }

            $this->set(compact('category'));
        }else{
            $category = $this->Categories->find()->where(['id'=>$id])->first();
            $cateParents = $this->Categories->find()->where(['parent_id'=>0])->toArray();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $request = $this->request->getData();
                $request['id'] = $id;
                $result = $this->categories->update($request);
                if($result){
                    $this->Flash->success(__('The category updated.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }

            $this->set(compact('category', 'cateParents'));
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $check = $this->categories->checkParent($id);
        if($check == 1){
            $this->connection->begin();
            $this->Categories->query()->delete()->where(['id' => $id])->execute();
            $cateChilds = $this->Categories->find()->where(['parent_id'=>$id])->toArray();
            foreach ($cateChilds as $cateChild) {
                $this->Categories->query()->delete()->where(['id' => $cateChild['id']])->execute();
            }
            $result = $this->connection->commit();
        }else{
            $result = $this->Categories->query()->delete()->where(['id' => $id])->execute();
        }
        
        if ($result) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
