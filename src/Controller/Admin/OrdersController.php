<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;
use Cake\View\Helper;
use Cake\Database\Expression\QueryExpression;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
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
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $orders = $this->paginate($this->Orders->find());

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'OrderDetails']
        ]);
        $this->set('order', $order);
    }

    public function edit($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            $result = $this->Orders->query()->update()
            ->set(['status' => $request['status'], 'note' => $request['note'], 'modified' => new DateTime('now')])
            ->where(['id' => $id])
            ->execute();
            if ($result) {
                $this->Flash->success(__('The order has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be updated. Please, try again.'));
        }
        $this->render(false);
    }

    public function search()
    {
        $this->viewBuilder()->autoLayout(false);

        $request = $this->request->getData();
        $this->paginate = [
            'contain' => ['Users']
        ];
        $query = $this->Orders->find();

        if(!empty($request['status'])){
            $query = $query->where(['orders.status'=>$request['status']]);
        }
        
        if(!empty($request['data'])){
           $query = $query->where(['OR'=>[['orders.name LIKE' => '%' . $request['data'] . '%'],
            ['orders.email LIKE' => '%' . $request['data'] . '%'],
            ['orders.address LIKE' => '%' . $request['data'] . '%'],
            ['orders.phone LIKE' => '%' . (int)$request['data'] . '%']]]);
       }

    $orders = $this->paginate($query);
    $this->set(compact('orders'));
    }
}
