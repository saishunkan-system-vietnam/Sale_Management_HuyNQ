<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

class HomeComponent extends Component {
    private $Categories;
    private $Products;
    private $Images;
    private $ProductAttributes;
    private $Users;
    private $Orders;
    private $OrderDetails;
    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->Users=TableRegistry::getTableLocator()->get('Users');
        $this->Orders = TableRegistry::get('Orders');
        $this->ProductAttributes = TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->OrderDetails=TableRegistry::getTableLocator()->get('OrderDetails');
        $this->connection = ConnectionManager::get('default');
    }

    public function addUser($reqUser){
        $user = $this->Users->newEntity();
        $user->email = $reqUser['email'];
        $user->password = md5($reqUser['password']);
        $user->name = $reqUser['name'];
        $user->phone = $reqUser['phone'];
        $user->address = $reqUser['address'];
        $user->type = 0;
        $user->notice = 'user';
        $user->status = 1;
        $user->created = new DateTime('now');
        $user->modified = new DateTime('now');
        $user = $this->Users->save($user);

        return $user;
    }

    public function addOrder($reqOrder,$cart,$user_id){
        $order = $this->Orders->newEntity();
        $order->user_id = $user_id;
        $order->name = $reqOrder['name'];
        $order->phone = (int)$reqOrder['phone'];
        $order->address = $reqOrder['address'];
        $order->email = $reqOrder['email'];
        $order->total = $reqOrder['total'];
        $order->status = 0;
        $order->note = "Waiting Process";
        $order->created = new DateTime('now');
        $order->modified = new DateTime('now');
        if($this->Orders->save($order)) {
            foreach ($cart as $value) {
                        $this->OrderDetails->query()->insert(['order_id', 'product_id', 'name', 'price', 'quantity','created','modified'])
                                                ->values([
                                                    'order_id' => $order['id'],
                                                    'product_id' => $value['id'],
                                                    'name' => $value['name'],
                                                    'price' => $value['price'],
                                                    'quantity' => $value['quantity'],
                                                    'created' => new DateTime('now'),
                                                    'modified' => new DateTime('now')
                                                ])
                                                ->execute();
            }
        } else {            
            $this->Flash->error(__('The Order could not be sended. Please, try again.'));
        }
    }
}
?>

