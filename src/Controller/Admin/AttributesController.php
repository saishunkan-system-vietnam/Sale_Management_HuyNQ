<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

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
    public function initialize()
    {
        parent::initialize();  
        $this->loadComponent('Attributes');
        $this->loadModel('Products');
        $this->loadModel('Attributes');
        $this->loadModel('ProductAttributes'); 
        $this->viewBuilder()->layout("admin");    
        $this->connection = ConnectionManager::get('default');
    }

    public function index()
    {
        $attributes = $this->Attributes->getData();
        // echo "<pre>";
        // print_r($attributes);
        // echo "</pre>";
        // die('a');
        if ($this->request->is('post')) {
            $request = $this->request->getData();
            foreach ($request as $key => $req) {
                if($req == null){
                    unset($request[$key]);
                }
            }
            $this->connection->begin();
            foreach ($request as $key => $req) {
                $nameParent = explode('_', $key);
                $idParent = $nameParent[0];
                $this->Attributes->query()->insert(['name', 'parent_id'])
                    ->values([
                        'name' => $req,
                        'parent_id' => $idParent
                    ])
                    ->execute();
            }
            $result = $this->connection->commit();
            if($result){
                $this->Flash->success(__('The attributes has been saved.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->success(__('Save faild.'));
            }
        }
        $this->set(compact('attributes'));
    }

    /**
     * View method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attribute = $this->Attributes->get($id, [
            'contain' => ['ParentAttributes', 'ChildAttributes', 'ProductAttributes']
        ]);

        $this->set('attribute', $attribute);
    }
}
