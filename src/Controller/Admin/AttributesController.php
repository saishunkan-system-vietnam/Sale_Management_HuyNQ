<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Attributes Controller
 *
 * @property \App\Model\Table\AttributesTable $Attributes
 *
 * @method \App\Model\Entity\Attribute[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttributesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    private $Attributes;
    private $ProductAttributes;
    public function initialize()
    {
        parent::initialize();  
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes = TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->loadComponent('attributes');
        $this->viewBuilder()->layout("admin");    
        $this->connection = ConnectionManager::get('default');
    }

    public function index()
    {
        $attrParents = $this->Attributes->find()->where(['parent_id' => 0])->toArray();
        $attrChilds = $this->attributes->selectChild();

        $this->set(compact('attrParents','attrChilds'));
    }

    /**
     * View method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add()
    {
        $attrParents = $this->Attributes->find()->where(['parent_id' => 0])->toArray();
        if ($this->request->is('post')) {
            $request = $this->request->getData();
            // echo "<pre>";
            // print_r($request);
            // echo "</pre>";
            // die('a');
            if(!isset($request['attribute'])){
                $this->Attributes->query()->insert(['name', 'parent_id'])
                ->values([
                    'name' => $request['name'],
                    'parent_id' => 0
                ])
                ->execute();
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Attributes->query()->insert(['name', 'parent_id'])
                ->values([
                    'name' => $request['name'],
                    'parent_id' => $request['attribute']
                ])
                ->execute();
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The Attribute could not be saved. Please, try again.'));
        }
        $this->set(compact('attrParents'));
    }

    public function edit($id = null)
    {
        $check = $this->attributes->checkParent($id);
        if($check == 1){
            $attribute = $this->Attributes->find()->where(['id'=>$id])->first();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $request = $this->request->getData();
                $this->connection->begin();
                $request['id'] = $id;
                $request['attribute'] = 0;
                $this->attributes->update($request);
                
                $attrChilds = $this->Attributes->find()->where(['parent_id'=>$id])->toArray();
                foreach ($attrChilds as $attrChild) {
                    $request['id'] = $attrChild['id'];
                    $request['name'] = $attrChild['name'];
                    $request['attribute'] = $id;
                    $this->attributes->update($request);
                }
                $result = $this->connection->commit();
                if($result){
                    $this->Flash->success(__('The attribute updated.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
            }

            $this->set(compact('attribute'));
        }else{
            $attribute = $this->Attributes->find()->where(['id'=>$id])->first();
            $attrParents = $this->Attributes->find()->where(['parent_id'=>0])->toArray();

            if ($this->request->is(['patch', 'post', 'put'])) {
                $request = $this->request->getData();
                $request['id'] = $id;
                $result = $this->attributes->update($request);
                if($result){
                    $this->Flash->success(__('The category updated.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }

            $this->set(compact('attribute', 'attrParents'));
        }
    }

    public function view($id = null){
        $attrChilds = $this->Attributes->find()->where(['parent_id'=>$id])->toArray();
    
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($attrChilds));
    }
}
