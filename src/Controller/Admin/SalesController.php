<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;
use Cake\View\Helper;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

/**
 * Sales Controller
 *
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{
    private $Products;
    private $Attributes;
    private $Images;
    private $ProductAttributes;
    private $Categories;

    public function initialize()
    {   
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->Categories=TableRegistry::getTableLocator()->get('Categories');
        $this->loadComponent('products');
        $this->loadComponent('attributes');
        $this->loadComponent('categories');
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("admin");
        date_default_timezone_set("Asia/Ho_Chi_Minh");
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products'],
            'maxLimit' => 10
        ];
        $sales = $this->paginate($this->Sales->find());

        $this->set(compact('sales'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => []
        ]);

        $this->set('sale', $sale);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Products']
        ]);
        $startday = new FrozenTime($sale->startday);
        $sale->startday = str_replace( ' ', 'T', $startday->format('Y-m-d H:i'));
        $endday = new FrozenTime($sale->endday);
        $sale->endday = str_replace( ' ', 'T', $endday->format('Y-m-d H:i'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $validation = $this->Sales->newEntity($request, ['validate' => 'edit']);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
                $this->set('request', $request);
            }else{
                $request['startday'] = str_replace( 'T', ' ', $request['startday']);
                $request['endday'] = str_replace( 'T', ' ', $request['endday']);
                $result = $this->Sales->query()->update()
                ->set(['value' => $request['value'],'startday' => $request['startday'],'endday' => $request['endday']])
                ->where(['id' => $id])
                ->execute();
                if ($result) {
                    $this->Flash->success(__('The sale has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The sale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('sale'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // $this->request->allowMethod(['post', 'delete']);
        $this->connection->begin();
            $query = $this->Sales->query();
            $result = $query->update()
            ->set(['status' => 0])
            ->where(['id' => $id])
            ->execute();

        $result = $this->connection->commit();
        if ($result) {
            $this->Flash->success(__('The sale has been deleted.'));
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function restore($id = null)
    {
        $this->connection->begin();
            $query = $this->Sales->query();
            $result = $query->update()
            ->set(['status' => 1])
            ->where(['id' => $id])
            ->execute();
        $result = $this->connection->commit();
        if ($result) {
            $this->Flash->success(__('The sale has been restored.'));
        } else {
            $this->Flash->error(__('The sale could not be restored. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
