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
        $categories = $this->categories->selectAll();
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
                $this->Categories->query()->insert(['name', 'parent_id'])
                    ->values([
                        'name' => $req,
                        'parent_id' => $idParent
                    ])
                    ->execute();
            }
            $result = $this->connection->commit();
            if($result){
                $this->Flash->success(__('The categories has been saved.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->success(__('Save faild.'));
            }
        }
        $this->set(compact('categories'));
    }
}
