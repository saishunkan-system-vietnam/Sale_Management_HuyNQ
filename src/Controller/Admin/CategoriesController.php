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
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function initialize()
    {
        parent::initialize();  
        $this->loadComponent('Categories');
        $this->loadModel('Categories');
        $this->loadModel('Products');
        $this->loadModel('ProductCategories'); 
        $this->viewBuilder()->layout("admin");    
        $this->connection = ConnectionManager::get('default');
    }

    public function index()
    {
        $categories = $this->Categories->getData();
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
                $this->connection->execute('INSERT INTO categories(name, parent_id) VALUES (?,?)',[$req,$idParent],['string','integer']);
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
